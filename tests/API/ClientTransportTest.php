<?php
/*
 * Created on   : Wed Jul 29 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ClientTransportTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\API;

use GuzzleHttp\{Client as HttpClient, HandlerStack};
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Lexoffice\API\Client;
use Lexoffice\API\Endpoints\{ContactsEndpoint, FilesEndpoint};
use Lexoffice\Entities\Files\File;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * Deckt die Transportschicht ab, die die Endpoint-Tests mit ihrem
 * ApiClientInterface-Mock überspringen: Ziel-URL inklusive Versionspfad,
 * Auth-Header und Content-Type der tatsächlich abgesetzten Requests.
 */
class ClientTransportTest extends TestCase {
    private MockHandler $handler;

    protected function setUp(): void {
        parent::setUp();
        $this->handler = new MockHandler;
    }

    public function test_request_carries_the_version_path_and_bearer_token(): void {
        $this->handler->append(new Response(200, ['Content-Type' => 'application/json'], (string) json_encode([
            'content' => [],
            'totalPages' => 0,
            'totalElements' => 0,
            'numberOfElements' => 0,
            'size' => 25,
            'number' => 0,
        ])));

        $client = $this->client();
        (new ContactsEndpoint($client))->search(['email' => 'kunde@example.com']);

        $request = $this->lastRequest();
        $this->assertSame('GET', $request->getMethod());
        // Ohne eigenen Pfadaufbau verschluckt Guzzles base_uri-Auflösung das /v1.
        $this->assertSame(
            'https://api.lexoffice.io/v1/contacts?email=kunde%40example.com',
            (string) $request->getUri()
        );
        $this->assertSame('Bearer api-key', $request->getHeaderLine('Authorization'));
    }

    public function test_legacy_base_url_with_version_path_is_accepted(): void {
        $this->handler->append(new Response(200, ['Content-Type' => 'application/json'], (string) json_encode([
            'content' => [], 'totalPages' => 0, 'totalElements' => 0, 'numberOfElements' => 0, 'size' => 25, 'number' => 0,
        ])));

        // Bis v1.1.1 trug die baseUrl den Versionspfad selbst.
        $client = new Client('api-key', 'https://api.lexoffice.io/v1/', null, false, $this->httpClient());
        $client->setRequestInterval(0.0);
        (new ContactsEndpoint($client))->search([]);

        $this->assertSame('https://api.lexoffice.io/v1/contacts', (string) $this->lastRequest()->getUri());
    }

    public function test_json_payload_is_sent_as_application_json(): void {
        $this->handler->append(new Response(200, ['Content-Type' => 'application/json'], (string) json_encode([
            'id' => 'e9066f04-8cc7-4616-93f8-ac9571762f49',
            'resourceUri' => 'https://api.lexoffice.io/v1/contacts/e9066f04-8cc7-4616-93f8-ac9571762f49',
            'createdDate' => '2024-01-01T10:00:00.000+01:00',
            'updatedDate' => '2024-01-01T10:00:00.000+01:00',
            'version' => 1,
        ])));

        $client = $this->client();
        (new ContactsEndpoint($client))->create(new \Lexoffice\Entities\Contacts\Contact([
            'version' => 0,
            'roles' => ['customer' => []],
            'company' => ['name' => 'Musterfirma GmbH'],
        ]));

        $request = $this->lastRequest();
        $this->assertSame('https://api.lexoffice.io/v1/contacts', (string) $request->getUri());
        $this->assertSame('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('Musterfirma GmbH', (string) $request->getBody());
    }

    public function test_upload_is_sent_as_multipart_not_json(): void {
        $this->handler->append(new Response(202, ['Content-Type' => 'application/json'], (string) json_encode([
            'id' => 'ac1d6e3a-1f6b-4c2f-9c1a-1a2b3c4d5e6f',
            'resourceUri' => 'https://api.lexoffice.io/v1/files/ac1d6e3a-1f6b-4c2f-9c1a-1a2b3c4d5e6f',
        ])));

        $path = tempnam(sys_get_temp_dir(), 'lexoffice-upload') . '.pdf';
        file_put_contents($path, '%PDF-1.4 test');

        try {
            (new FilesEndpoint($this->client()))->upload(new File(['filePath' => $path]));
        } finally {
            @unlink($path);
        }

        // Ein Default-Content-Type am Client würde Guzzles Multipart-Boundary
        // verdrängen — der Upload ginge als application/json raus.
        $this->assertStringStartsWith('multipart/form-data; boundary=', $this->lastRequest()->getHeaderLine('Content-Type'));
    }

    private function client(): Client {
        $client = new Client('api-key', Client::DEFAULT_BASE_URL, null, false, $this->httpClient());
        $client->setRequestInterval(0.0);

        return $client;
    }

    private function httpClient(): HttpClient {
        return new HttpClient(['handler' => HandlerStack::create($this->handler)]);
    }

    private function lastRequest(): RequestInterface {
        $request = $this->handler->getLastRequest();
        $this->assertNotNull($request);

        return $request;
    }
}
