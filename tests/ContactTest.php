<?php

declare(strict_types=1);

namespace Tests\Lexoffice\Entities;

use Lexoffice\Entities\Contact\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase {
    public function testCreateContact() {
        $data = [
            "id" => "be9475f4-ef80-442b-8ab9-3ab8b1a2aeb9",
            "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
            "version" => 1,
            "roles" => [
                "customer" => [
                    "number" => 10307
                ],
                "vendor" => [
                    "number" => 70303
                ]
            ],
            "company" => [
                "name" => "Testfirma",
                "taxNumber" => "12345/12345",
                "vatRegistrationId" => "DE123456789",
                "allowTaxFreeInvoices" => true,
                "contactPersons" => [
                    [
                        "salutation" => "Herr",
                        "firstName" => "Max",
                        "lastName" => "Mustermann",
                        "primary" => true,
                        "emailAddress" => "contactpersonmail@lexoffice.de",
                        "phoneNumber" => "08000/11111"
                    ],
                    [
                        "salutation" => "Frau",
                        "firstName" => "Manuela",
                        "lastName" => "Mustermann",
                        "primary" => true,
                        "emailAddress" => "contactpersonmail@lexoffice.de",
                        "phoneNumber" => "08000/11111"
                    ]
                ]
            ],
            "addresses" => [
                "billing" => [
                    [
                        "supplement" => "Rechnungsadressenzusatz",
                        "street" => "Hauptstr. 5",
                        "zip" => "12345",
                        "city" => "Musterort",
                        "countryCode" => "DE"
                    ],
                    [
                        "supplement" => "Rechnungsadressenzusatz1",
                        "street" => "Hauptstr. 52",
                        "zip" => "12344",
                        "city" => "Musterort",
                        "countryCode" => "DE"
                    ]
                ],
                "shipping" => [
                    [
                        "supplement" => "Lieferadressenzusatz",
                        "street" => "Schulstr. 13",
                        "zip" => "76543",
                        "city" => "MUsterstadt",
                        "countryCode" => "DE"
                    ]
                ]
            ],
            "xRechnung" => [
                "buyerReference" => "04011000-1234512345-35",
                "vendorNumberAtCustomer" => "70123456"
            ],
            "emailAddresses" => [
                "business" => [
                    "business@lexoffice.de",
                    "business1@lexoffice.de"
                ],
                "office" => [
                    "office@lexoffice.de"
                ],
                "private" => [
                    "private@lexoffice.de"
                ],
                "other" => [
                    "other@lexoffice.de"
                ]
            ],
            "phoneNumbers" => [
                "business" => [
                    "08000/1231",
                    "08000/1222"
                ],
                "office" => [
                    "08000/1232"
                ],
                "mobile" => [
                    "08000/1233"
                ],
                "private" => [
                    "08000/1234"
                ],
                "fax" => [
                    "08000/1235"
                ],
                "other" => [
                    "08000/1236"
                ]
            ],
            "note" => "Notizen",
            "archived" => false
        ];


        $contact = new Contact($data);
        $this->assertInstanceOf(Contact::class, $contact);
        //$this->assertEquals('Lexware buchhaltung Premium 2024', $contact->title);
        //$this->assertTrue($article->archived);
        //$this->assertIsArray($company->contactPersons);
        //$this->assertInstanceOf(ContactPerson::class, $company->contactPersons[0]);
    }
}
