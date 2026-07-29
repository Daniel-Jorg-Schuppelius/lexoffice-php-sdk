<?php
/*
 * Created on   : Wed Jul 29 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PagedSearchTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\API;

use GuzzleHttp\{Client as HttpClient, HandlerStack, Middleware};
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Lexoffice\API\Client;
use Lexoffice\API\Endpoints\ContactsEndpoint;
use Lexoffice\Entities\Contacts\Contact;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * searchAll() läuft die Seiten über den OffsetPaginator des api-toolkits
 * durch, statt Aufrufern den Seitenzähler zu überlassen.
 */
class PagedSearchTest extends TestCase {
    /** @var array<int, RequestInterface> */
    private array $requests = [];

    private MockHandler $handler;

    /**
     * Guzzles Middleware::history() schreibt in ein array|ArrayAccess und ist
     * damit nicht typisierbar; dieser Recorder hält nur die Requests fest.
     */
    private function recorder(): callable {
        return function (callable $handler): callable {
            return function (RequestInterface $request, array $options) use ($handler) {
                $this->requests[] = $request;

                return $handler($request, $options);
            };
        };
    }

    protected function setUp(): void {
        parent::setUp();
        $this->handler = new MockHandler;
        $this->requests = [];
    }

    public function test_search_all_follows_every_page(): void {
        $this->handler->append(
            new Response(200, [], $this->page(['a', 'b'], 2, 0, 2)),
            new Response(200, [], $this->page(['c'], 2, 1, 2)),
        );

        $endpoint = new ContactsEndpoint($this->client());
        $names = [];
        foreach ($endpoint->searchAll(['email' => 'k@example.com'], 2) as $contact) {
            $this->assertInstanceOf(Contact::class, $contact);
            $names[] = $contact->getCompany()?->getName();
        }

        $this->assertSame(['a', 'b', 'c'], $names);
        $this->assertCount(2, $this->requests);
        $this->assertStringContainsString('page=0&size=2', (string) $this->requests[0]->getUri());
        $this->assertStringContainsString('page=1&size=2', (string) $this->requests[1]->getUri());
    }

    public function test_search_all_stops_on_a_short_page(): void {
        // Eine Seite mit weniger Treffern als angefordert ist die letzte —
        // ein weiterer Request wäre verschwendet.
        $this->handler->append(new Response(200, [], $this->page(['a'], 5, 0, 1)));

        $endpoint = new ContactsEndpoint($this->client());
        $this->assertCount(1, iterator_to_array($endpoint->searchAll([], 5), false));
        $this->assertCount(1, $this->requests);
    }

    public function test_max_pages_caps_the_iteration(): void {
        $this->handler->append(
            new Response(200, [], $this->page(['a'], 1, 0, 3)),
            new Response(200, [], $this->page(['b'], 1, 1, 3)),
            new Response(200, [], $this->page(['c'], 1, 2, 3)),
        );

        $endpoint = new ContactsEndpoint($this->client());
        $this->assertCount(2, iterator_to_array($endpoint->searchAll([], 1, [], 2), false));
        $this->assertCount(2, $this->requests);
    }

    /**
     * @param array<int, string> $companyNames
     */
    private function page(array $companyNames, int $size, int $number, int $totalPages): string {
        return (string) json_encode([
            'content' => array_map(static fn (string $name): array => [
                'id' => 'e9066f04-8cc7-4616-93f8-ac9571762f49',
                'version' => 1,
                'roles' => ['customer' => []],
                'company' => ['name' => $name],
            ], $companyNames),
            'first' => $number === 0,
            'last' => $number === $totalPages - 1,
            'totalPages' => $totalPages,
            'totalElements' => $totalPages * $size,
            'numberOfElements' => count($companyNames),
            'size' => $size,
            'number' => $number,
            'sort' => [],
        ]);
    }

    private function client(): Client {
        $stack = HandlerStack::create($this->handler);
        $stack->push($this->recorder());

        $client = new Client('api-key', Client::DEFAULT_BASE_URL, null, false, new HttpClient(['handler' => $stack]));
        $client->setRequestInterval(0.0);

        return $client;
    }
}
