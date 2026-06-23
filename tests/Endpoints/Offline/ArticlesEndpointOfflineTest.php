<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ArticlesEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\ArticlesEndpoint;
use Lexoffice\Entities\Articles\{Article, ArticleResource, ArticlesPage};
use Tests\Contracts\OfflineEndpointTest;

class ArticlesEndpointOfflineTest extends OfflineEndpointTest {
    private ArticlesEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new ArticlesEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('POST', 'articles', 201, json_encode([
            'id' => 'eb46d328-e1dc-11ee-8444-2fadfc15a567',
            'resourceUri' => 'https://api.lexoffice.io/v1/articles/eb46d328-e1dc-11ee-8444-2fadfc15a567',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 1,
        ]));

        $this->mockClient->addResponse('GET', 'articles/eb46d328-e1dc-11ee-8444-2fadfc15a567', 200, json_encode([
            'id' => 'eb46d328-e1dc-11ee-8444-2fadfc15a567',
            'title' => 'Test Article',
            'type' => 'PRODUCT',
            'articleNumber' => 'ART-001',
            'unitName' => 'Stück',
            'price' => [
                'netPrice' => 100.00,
                'leadingPrice' => 'NET',
                'taxRate' => 19.0,
            ],
            'version' => 1,
        ]));

        $this->mockClient->addResponse('GET', 'articles', 200, json_encode([
            'content' => [],
            'first' => true,
            'last' => true,
            'totalPages' => 0,
            'totalElements' => 0,
            'numberOfElements' => 0,
            'size' => 25,
            'number' => 0,
            'sort' => [],
        ]));
    }

    public function test_create_article(): void {
        $data = [
            'title' => 'Test Article',
            'type' => 'PRODUCT',
            'unitName' => 'Stück',
            'articleNumber' => 'ART-001',
            'price' => [
                'netPrice' => 100.00,
                'leadingPrice' => 'NET',
                'taxRate' => 19.0,
            ],
        ];

        $article = new Article($data);
        $result = $this->endpoint->create($article);

        $this->assertInstanceOf(ArticleResource::class, $result);
        $this->assertEquals('eb46d328-e1dc-11ee-8444-2fadfc15a567', $result->getId()->toString());
        $this->assertRequestMade('POST', 'articles');
    }

    public function test_get_article(): void {
        $id = new ID('eb46d328-e1dc-11ee-8444-2fadfc15a567');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(Article::class, $result);
        $this->assertEquals('Test Article', $result->getTitle());
        $this->assertEquals('PRODUCT', $result->getType()->value);
        $this->assertRequestMade('GET', 'articles/eb46d328-e1dc-11ee-8444-2fadfc15a567');
    }

    public function test_get_article_without_id_throws_exception(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }

    public function test_update_article(): void {
        $this->mockClient->addResponse('PUT', 'articles/eb46d328-e1dc-11ee-8444-2fadfc15a567', 200, json_encode([
            'id' => 'eb46d328-e1dc-11ee-8444-2fadfc15a567',
            'resourceUri' => 'https://api.lexoffice.io/v1/articles/eb46d328-e1dc-11ee-8444-2fadfc15a567',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T11:00:00.000+01:00',
            'version' => 2,
        ]));

        $id = new ID('eb46d328-e1dc-11ee-8444-2fadfc15a567');
        $article = new Article([
            'title' => 'Updated Article',
            'type' => 'PRODUCT',
            'version' => 1,
        ]);

        $result = $this->endpoint->update($id, $article);

        $this->assertInstanceOf(ArticleResource::class, $result);
        $this->assertRequestMade('PUT', 'articles/eb46d328-e1dc-11ee-8444-2fadfc15a567');
    }

    public function test_delete_article(): void {
        $this->mockClient->addResponse('DELETE', 'articles/eb46d328-e1dc-11ee-8444-2fadfc15a567', 204, '');

        $id = new ID('eb46d328-e1dc-11ee-8444-2fadfc15a567');
        $result = $this->endpoint->delete($id);

        $this->assertTrue($result);
        $this->assertRequestMade('DELETE', 'articles/eb46d328-e1dc-11ee-8444-2fadfc15a567');
    }

    public function test_search_articles(): void {
        $result = $this->endpoint->search();

        $this->assertInstanceOf(ArticlesPage::class, $result);
        $this->assertRequestMade('GET', 'articles*');
    }
}
