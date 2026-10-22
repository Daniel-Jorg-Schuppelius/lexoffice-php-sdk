<?php
/*
 * Created on   : Wed Oct 21 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : TransportTestCase.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Contracts;

use GuzzleHttp\{Client as HttpClient, HandlerStack};
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Lexoffice\API\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * Echter Client über einen Guzzle-MockHandler: geprüft wird, was tatsächlich
 * hinausgeht (URL, Header, Body).
 */
abstract class TransportTestCase extends TestCase {
    protected MockHandler $handler;

    /** @var list<RequestInterface> */
    private array $requests = [];

    protected function setUp(): void {
        parent::setUp();
        $this->handler = new MockHandler;
        $this->requests = [];
    }

    protected function client(): Client {
        $stack = HandlerStack::create($this->handler);
        $stack->push(function (callable $next): callable {
            return function (RequestInterface $request, array $options) use ($next) {
                $this->requests[] = $request;

                return $next($request, $options);
            };
        });

        $client = new Client('api-key', Client::DEFAULT_BASE_URL, null, false, new HttpClient(['handler' => $stack]));
        $client->setRequestInterval(0.0);

        return $client;
    }

    /**
     * @param array<int|string, mixed> $body
     * @param array<string, string> $headers
     */
    protected function respondJson(int $status, array $body, array $headers = []): void {
        $this->handler->append(new Response($status, ['Content-Type' => 'application/json'] + $headers, (string) json_encode($body)));
    }

    protected function respondCreated(string $id = 'e9066f04-8cc7-4616-93f8-ac9ecc8479c8'): void {
        $this->respondJson(201, [
            'id' => $id,
            'resourceUri' => "https://api.lexware.io/v1/invoices/{$id}",
            'createdDate' => '2023-06-29T15:15:09.447+02:00',
            'updatedDate' => '2023-06-29T15:15:09.447+02:00',
            'version' => 1,
        ]);
    }

    protected function lastRequest(): RequestInterface {
        $request = end($this->requests);
        $this->assertNotFalse($request, 'Es wurde keine Anfrage gesendet.');

        return $request;
    }

    /**
     * @return array<string, mixed>
     */
    protected function lastJsonBody(): array {
        $decoded = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertIsArray($decoded);

        return $decoded;
    }
}
