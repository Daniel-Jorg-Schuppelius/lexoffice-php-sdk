<?php

declare(strict_types=1);

namespace Tests\Lexoffice\Entities;

use Lexoffice\Entities\Article\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase {
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
                "taxRate" => 19
            ],
            "version" => 2
        ];

        $article = new Article($data);
        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals('Lexware buchhaltung Premium 2024', $article->title);
        //$this->assertTrue($article->archived);
        //$this->assertIsArray($company->contactPersons);
        //$this->assertInstanceOf(ContactPerson::class, $company->contactPersons[0]);
    }
}
