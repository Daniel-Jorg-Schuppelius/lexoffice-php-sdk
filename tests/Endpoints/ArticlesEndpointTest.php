<?php

namespace Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use Lexoffice\Api\Endpoints\ArticlesEndpoint;
use Lexoffice\API\Client;
use Lexoffice\Entities\Articles\ArticleResource;
use Tests\Config\PostmanConfig;

class ArticlesEndpointTest extends TestCase {
    private $client;
    private $articlesEndpoint;
    private PostmanConfig $config;

    private bool $apiDisabled = false;

    protected function setUp(): void {
        if (!$this->apiDisabled) {
            $this->config = new PostmanConfig();
            $this->client = new Client($this->config->accessToken, $this->config->resourceUrl . '/v1/');
            $this->articlesEndpoint = new ArticlesEndpoint($this->client);

            try {
                $response = $this->client->get("ping");
                $this->apiDisabled = $response->getStatusCode() != 200;
            } catch (\Exception $e) {
                $this->apiDisabled = true;
            }
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

        $articleResource = $this->articlesEndpoint->create($data);
        $this->assertInstanceOf(ArticleResource::class, $articleResource);
        $this->articlesEndpoint->delete($articleResource->getId()->toString());
    }

    public function testCreateUpdateAndDeleteArticleAPI() {
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

        $articleResource = $this->articlesEndpoint->create($data);
        $this->assertInstanceOf(ArticleResource::class, $articleResource);
        $article = $this->articlesEndpoint->get($articleResource->getId()->toString());

        $article->title = "Lexware buchhaltung Premium 2022 Updated";
        $articleResourceUpdated = $this->articlesEndpoint->update($articleResource->getId()->toString(), $article->toArray());
        $this->assertInstanceOf(ArticleResource::class, $articleResourceUpdated);

        $this->articlesEndpoint->delete($articleResource->getId()->toString());
    }
}
