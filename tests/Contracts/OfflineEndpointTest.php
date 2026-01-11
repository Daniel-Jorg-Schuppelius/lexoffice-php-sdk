<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : OfflineEndpointTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Contracts;

use ERRORToolkit\Factories\ConsoleLoggerFactory;
use ERRORToolkit\LoggerRegistry;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Tests\Mocks\MockApiClient;

abstract class OfflineEndpointTest extends TestCase {
    protected ?LoggerInterface $logger = null;
    protected MockApiClient $mockClient;

    public function __construct($name) {
        parent::__construct($name);
        $this->logger = ConsoleLoggerFactory::getLogger();
        LoggerRegistry::setLogger($this->logger);
        $this->mockClient = new MockApiClient();
    }

    protected function setUp(): void {
        parent::setUp();
        $this->mockClient->clearRequestLog();
        $this->mockClient->clearResponses();
        $this->setupMockResponses();
    }

    /**
     * Override this method to set up mock responses for your endpoint tests
     */
    protected function setupMockResponses(): void {
        // Override in subclasses
    }

    /**
     * Assert that a request was made with the given method and URI
     */
    protected function assertRequestMade(string $method, string $uriPattern): void {
        $found = false;
        foreach ($this->mockClient->getRequestLog() as $request) {
            if ($request['method'] === $method && $this->matchUri($request['uri'], $uriPattern)) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, "Expected {$method} request to {$uriPattern} was not made");
    }

    /**
     * Assert that no requests were made
     */
    protected function assertNoRequestsMade(): void {
        $this->assertEmpty($this->mockClient->getRequestLog(), 'Expected no requests to be made');
    }

    /**
     * Get the body from the last request
     */
    protected function getLastRequestBody(): ?string {
        $lastRequest = $this->mockClient->getLastRequest();
        return $lastRequest['options']['body'] ?? null;
    }

    private function matchUri(string $uri, string $pattern): bool {
        if ($uri === $pattern) {
            return true;
        }
        $regex = str_replace(['/', '*'], ['\/', '.*'], $pattern);
        return (bool) preg_match('/^' . $regex . '$/', $uri);
    }
}
