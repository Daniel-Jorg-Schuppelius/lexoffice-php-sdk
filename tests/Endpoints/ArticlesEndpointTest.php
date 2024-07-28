<?php

namespace Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use Lexoffice\Api\Endpoints\ArticlesEndpoint;
use Lexoffice\API\Client;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Entities\Articles\ArticleResource;
use Lexoffice\Entities\Articles\ArticlesPage;
use Lexoffice\Logger\ConsoleLogger;
use Tests\Config\PostmanConfig;

class ArticlesEndpointTest extends TestCase {
    private ?Client $client;
    private ?SearchableEndpointInterface $endpoint;
    private ?PostmanConfig $config;
    private ?ConsoleLogger $logger = null;

    private bool $apiDisabled = false;

    public function __construct($name) {
        parent::__construct($name);
        $this->config = new PostmanConfig();
        //$this->logger = new ConsoleLogger();
        $this->client = new Client($this->config->accessToken, $this->config->resourceUrl . '/v1/', $this->logger, true);
        $this->endpoint = new ArticlesEndpoint($this->client);
    }

    protected function setUp(): void {
        if (!$this->apiDisabled && $this->config->isConfigured()) {
            try {
                $response = $this->client->get("ping");
                $this->apiDisabled = $response->getStatusCode() != 200;
            } catch (\Exception $e) {
                $this->apiDisabled = true;
            }
        } else {
            $this->apiDisabled = true;
        }
    }

    public function testCreateAndDeleteArticleAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "title" => "Lexware buchhaltung Premium 2022",
            "type" => "PRODUCT",
            "unitName" => "Download-Code",
            "articleNumber" => "LXW-BUHA-2024-002",
            "price" => [
                "netPrice" => 61.90,
                "leadingPrice" => "NET",
                "taxRate" => 19.0
            ]
        ];

        $articleResource = $this->endpoint->create($data);
        $this->assertInstanceOf(ArticleResource::class, $articleResource);
        $this->endpoint->delete($articleResource->getId()->toString());
    }

    public function testCreateGetUpdateAndDeleteArticleAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "title" => "Lexware buchhaltung Premium 2022",
            "type" => "PRODUCT",
            "unitName" => "Download-Code",
            "articleNumber" => "LXW-BUHA-2024-002",
            "price" => [
                "netPrice" => 61.90,
                "leadingPrice" => "NET",
                "taxRate" => 19.0
            ]
        ];

        $articleResource = $this->endpoint->create($data);
        $this->assertInstanceOf(ArticleResource::class, $articleResource);
        $article = $this->endpoint->get($articleResource->getId()->toString());

        $article->title = "Lexware buchhaltung Premium 2022 Updated";
        $articleResourceUpdated = $this->endpoint->update($articleResource->getId()->toString(), $article->toArray());
        $this->assertInstanceOf(ArticleResource::class, $articleResourceUpdated);

        $this->endpoint->delete($articleResource->getId()->toString());
    }

    public function testCreateSearchAndDeleteArticleAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "title" => "Lexware buchhaltung Premium 2022",
            "type" => "PRODUCT",
            "unitName" => "Download-Code",
            "articleNumber" => "LXW-BUHA-2024-002",
            "price" => [
                "netPrice" => 61.90,
                "leadingPrice" => "NET",
                "taxRate" => 19.0
            ]
        ];

        $articlesPage = $this->endpoint->search();
        $this->assertInstanceOf(ArticlesPage::class, $articlesPage);

        $articleResource = $this->endpoint->create($data);
        $this->assertInstanceOf(ArticleResource::class, $articleResource);

        $articlesPageUpdated = $this->endpoint->search();
        $this->assertInstanceOf(ArticlesPage::class, $articlesPageUpdated);
        $this->assertGreaterThan($articlesPage->getTotalElements(), $articlesPageUpdated->getTotalElements());

        $this->endpoint->delete($articleResource->getId()->toString());
    }
}
