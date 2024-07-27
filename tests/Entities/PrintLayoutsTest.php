<?php

declare(strict_types=1);

namespace Tests\Entities;

use Lexoffice\Entities\PrintLayouts\PrintLayouts;
use PHPUnit\Framework\TestCase;

class PrintLayoutsTest extends TestCase {
    public function testCreatePrintLayouts() {
        $data = [
            [
                "id" => "0dda299a-b5db-11ee-93dd-1755da51b5dc",
                "name" => "Standard",
                "default" => true
            ],
            [
                "id" => "1ecf228c-b5db-11ee-bdaa-bbbd077b15cd",
                "name" => "Alternate layout",
                "default" => false
            ]
        ];
        $printLayouts = new PrintLayouts($data);
        $this->assertInstanceOf(PrintLayouts::class, $printLayouts);
    }
}
