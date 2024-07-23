<?php

declare(strict_types=1);

namespace Tests\Lexoffice\Entities;

use Lexoffice\Entities\PostingCategories\PostingCategories;
use PHPUnit\Framework\TestCase;

class PostingCategoriesTest extends TestCase {
    public function testCreatePostingCategories() {
        $data = [
            [
                "id" => "cf03a2b0-f838-474f-ac5e-67adb9b830c7",
                "name" => "Reise MA",
                "type" => "outgo",
                "contactRequired" => false,
                "splitAllowed" => true,
                "groupName" => "Reisen"
            ],
            [
                "id" => "3620798f-ae06-4492-b775-1c87eb99247c",
                "name" => "Fahrtkosten MA",
                "type" => "outgo",
                "contactRequired" => false,
                "splitAllowed" => true,
                "groupName" => "Reisen"
            ],
            [
                "id" => "8f8664a1-fd86-11e1-a21f-0800200c9a66",
                "name" => "Einnahmen",
                "type" => "income",
                "contactRequired" => false,
                "splitAllowed" => true,
                "groupName" => "Einnahmen"
            ],
            [
                "id" => "8f8664a0-fd86-11e1-a21f-0800200c9a66",
                "name" => "Dienstleistung",
                "type" => "income",
                "contactRequired" => false,
                "splitAllowed" => true,
                "groupName" => "Einnahmen"
            ]
        ];

        $postingCategories = new PostingCategories($data);
        $this->assertInstanceOf(PostingCategories::class, $postingCategories);
        //$this->assertEquals('Lexware buchhaltung Premium 2024', $postingCategories->name);
        //$this->assertTrue($article->archived);
        //$this->assertIsArray($company->contactPersons);
        //$this->assertInstanceOf(ContactPerson::class, $company->contactPersons[0]);
    }
}
