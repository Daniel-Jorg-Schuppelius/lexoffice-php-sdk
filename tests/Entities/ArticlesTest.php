<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ArticlesTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Entities;

use Lexoffice\Entities\Articles\Articles;
use Lexoffice\Entities\Articles\Article;
use Lexoffice\Entities\Articles\ArticlesPage;
use Lexoffice\Entities\Articles\Price;
use ERRORToolkit\Logger\ConsoleLogger;
use ERRORToolkit\Factories\ConsoleLoggerFactory;
use PHPUnit\Framework\TestCase;

class ArticlesTest extends TestCase {
    private ?ConsoleLogger $logger = null;

    public function __construct($name) {
        parent::__construct($name);
        $this->logger = ConsoleLoggerFactory::getLogger();
    }

    public function testCreateArticle() {
        $data = [
            "id" => "eb46d328-e1dc-11ee-8444-2fadfc15a567",
            "organizationId" => "9e700f44-0c55-11ef-ac31-8f7c36d1b6e2",
            "createdDate" => "2023-09-21T17:46:40.629+02:00",
            "updatedDate" => "2024-05-03T12:21:32.120+02:00",
            "archived" => false,
            "title" => "Lexware buchhaltung Premium 2024",
            "description" => "Monatsabonnement. Mehrplatzsystem zur Buchhaltung. Produkt vom Marktführer. PC Aktivierungscode per Email",
            "type" => "PRODUCT",
            "articleNumber" => "LXW-BUHA-2024-001",
            "gtin" => "9783648170632",
            "note" => "Interne Notiz",
            "unitName" => "Download-Code",
            "price" => [
                "netPrice" => 61.90,
                "grossPrice" => 73.66,
                "leadingPrice" => "NET",
                "taxRate" => 19.0
            ],
            "version" => 2
        ];

        $article = new Article($data, $this->logger);
        $price = new Price($data['price'], $this->logger);
        $this->assertTrue($article->isValid());
        $this->assertInstanceOf(Article::class, new Article());
        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals('Lexware buchhaltung Premium 2024', $article->getTitle());
        $this->assertEquals($data, $article->toArray());
        $this->assertEquals($price, $article->getPrice());
    }
    public function testCreateArticles() {
        $data = [
            "content" => [
                [
                    "id" => "eb46d328-e1dc-11ee-8444-2fadfc15a567",
                    "title" => "Lexware buchhaltung Premium 2024",
                    "description" => "Monatsabonnement. Mehrplatzsystem zur Buchhaltung. Produkt vom Marktführer. PC Aktivierungscode per Email",
                    "type" => "PRODUCT",
                    "articleNumber" => "LXW-BUHA-2024-001",
                    "gtin" => "9783648170632",
                    "note" => "Interne Notiz",
                    "unitName" => "Download-Code",
                    "price" => [
                        "netPrice" => 61.90,
                        "grossPrice" => 73.66,
                        "leadingPrice" => "NET",
                        "taxRate" => 19.0
                    ],
                    "version" => 1
                ],
                [
                    "id" => "f7e14ba6-e2ac-11ee-96c1-3b561501789e",
                    "title" => "Lexware warenwirtschaft Premium 2024",
                    "description" => "Monatsabonnement. Mehrplatzsystem zur kompletten Warenwirtschaft. Produkt vom Marktführer. PC Aktivierungscode per Email",
                    "type" => "PRODUCT",
                    "articleNumber" => "LXW-WAWI-2024-001",
                    "gtin" => "9783648170779",
                    "note" => "Interne Notiz",
                    "unitName" => "Download-Code",
                    "price" => [
                        "netPrice" => 61.90,
                        "grossPrice" => 73.66,
                        "leadingPrice" => "NET",
                        "taxRate" => 19.0
                    ],
                    "version" => 3
                ],
            ],
        ];

        $articles = new Articles($data, $this->logger);
        $this->assertInstanceOf(Articles::class, $articles);
        $this->assertInstanceOf(Article::class, $articles->getValues()[0]);
        $this->assertInstanceOf(Article::class, $articles->getValues()[1]);
        $this->assertEquals('Lexware buchhaltung Premium 2024', $articles->getValues()[0]->getTitle());
        $this->assertEquals('Lexware warenwirtschaft Premium 2024', $articles->getValues()[1]->getTitle());
        $this->assertIsArray($articles->getValues());
    }

    public function testCreateArticlesPage() {
        $data = [
            "content" => [
                [
                    "id" => "eb46d328-e1dc-11ee-8444-2fadfc15a567",
                    "title" => "Lexware buchhaltung Premium 2024",
                    "description" => "Monatsabonnement. Mehrplatzsystem zur Buchhaltung. Produkt vom Marktführer. PC Aktivierungscode per Email",
                    "type" => "PRODUCT",
                    "articleNumber" => "LXW-BUHA-2024-001",
                    "gtin" => "9783648170632",
                    "note" => "Interne Notiz",
                    "unitName" => "Download-Code",
                    "price" => [
                        "netPrice" => 61.90,
                        "grossPrice" => 73.66,
                        "leadingPrice" => "NET",
                        "taxRate" => 19.0
                    ],
                    "version" => 1
                ],
                [
                    "id" => "f7e14ba6-e2ac-11ee-96c1-3b561501789e",
                    "title" => "Lexware warenwirtschaft Premium 2024",
                    "description" => "Monatsabonnement. Mehrplatzsystem zur kompletten Warenwirtschaft. Produkt vom Marktführer. PC Aktivierungscode per Email",
                    "type" => "PRODUCT",
                    "articleNumber" => "LXW-WAWI-2024-001",
                    "gtin" => "9783648170779",
                    "note" => "Interne Notiz",
                    "unitName" => "Download-Code",
                    "price" => [
                        "netPrice" => 61.90,
                        "grossPrice" => 73.66,
                        "leadingPrice" => "NET",
                        "taxRate" => 19.0
                    ],
                    "version" => 3
                ],
            ],
            "totalPages" => 1,
            "totalElements" => 2,
            "last" => true,
            "sort" => [
                [
                    "direction" => "ASC",
                    "property" => "title",
                    "ignoreCase" => false,
                    "nullHandling" => "NATIVE",
                    "ascending" => true
                ]
            ],
            "size" => 25,
            "number" => 0,
            "first" => true,
            "numberOfElements" => 2
        ];

        $articlesPage = new ArticlesPage($data, $this->logger);
        $this->assertInstanceOf(ArticlesPage::class, $articlesPage);
        $this->assertInstanceOf(Articles::class, $articlesPage->getContent());
        $this->assertIsArray($articlesPage->getValues());
    }
}