<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ArticlesEndpointTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Tests\Endpoints;

use Lexoffice\API\Endpoints\ArticlesEndpoint;
use Lexoffice\Entities\Articles\{Article, ArticleResource, ArticlesPage};
use Tests\Contracts\EndpointTest;

class ArticlesEndpointTest extends EndpointTest {
    protected ArticlesEndpoint $endpoint;

    protected function setUp(): void {
        $this->apiDisabled = true; // API is disabled
        parent::setUp();
        $this->endpoint = new ArticlesEndpoint($this->client);
    }

    public function test_json_serialize(): void {
        $data = [
            "id" => "eb46d328-e1dc-11ee-8444-2fadfc15a567",
            "title" => "Lexware buchhaltung Premium 2024",
            "type" => "PRODUCT",
            "articleNumber" => "LXW-BUHA-2024-001",
            "unitName" => "Download-Code",
            "price" => [
                "netPrice" => 61.90,
                "leadingPrice" => "NET",
                "taxRate" => 19.0,
            ],
        ];

        $article = new Article($data);
        $this->assertEquals($data, $article->toArray());
        $this->assertEquals(json_encode($data), $article->toJson());  // the order of the $data array is important for this test.
        $articleId = $article->getID();
        $this->assertNotNull($articleId);
        $encodedData = json_encode($data);
        $this->assertNotFalse($encodedData);
        $this->assertStringContainsString(substr($articleId->toJson(), 2, -2), $encodedData);
        $this->assertEquals(json_encode($data["price"]), $article->getPrice()->toJson());
    }

    public function test_create_and_delete_article_api(): void {
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
                "taxRate" => 19.0,
            ],
        ];

        $article = new Article($data);
        $articleResource = $this->endpoint->create($article);
        $this->assertInstanceOf(ArticleResource::class, $articleResource);
        $this->endpoint->delete($articleResource->getId());
    }

    public function test_create_get_update_and_delete_article_api(): void {
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
                "taxRate" => 19.0,
            ],
        ];

        $articleResource = $this->endpoint->create(new Article($data));
        $this->assertInstanceOf(ArticleResource::class, $articleResource);
        $article = $this->endpoint->get($articleResource->getId());

        $article->setTitle("Lexware buchhaltung Premium 2022 Updated");
        $articleResourceUpdated = $this->endpoint->update($articleResource->getId(), $article);
        $this->assertInstanceOf(ArticleResource::class, $articleResourceUpdated);

        $this->endpoint->delete($articleResource->getId());
    }

    public function test_create_search_and_delete_article_api(): void {
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
                "taxRate" => 19.0,
            ],
        ];

        $articlesPage = $this->endpoint->search();
        $this->assertInstanceOf(ArticlesPage::class, $articlesPage);

        $articleResource = $this->endpoint->create(new Article($data));
        $this->assertInstanceOf(ArticleResource::class, $articleResource);

        $articlesPageUpdated = $this->endpoint->search();
        $this->assertInstanceOf(ArticlesPage::class, $articlesPageUpdated);
        $this->assertGreaterThan($articlesPage->getTotalElements(), $articlesPageUpdated->getTotalElements());

        $this->endpoint->delete($articleResource->getId());
    }
}
