<?php

declare(strict_types=1);

namespace Tests\Entities;

use Lexoffice\Entities\Contacts\Company;
use Lexoffice\Entities\Contacts\Contact;
use Lexoffice\Entities\Contacts\Contacts;
use Lexoffice\Entities\Contacts\ContactsPage;
use PHPUnit\Framework\TestCase;

class ContactsTest extends TestCase {
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
        $contactArray = $contact->toArray();
        $this->assertEquals($data, $contactArray);
        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertInstanceOf(Company::class, $contact->company);
        $this->assertTrue($contact->company->allowTaxFreeInvoices);
        $this->assertEquals('Max', $contact->company->contactPersons->getValues()[0]->firstName);
        $this->assertEquals('Mustermann', $contact->company->contactPersons->getValues()[1]->lastName);
    }
    public function testCreateContacts() {
        $data = [
            "content" => [
                [
                    "id" => "e9066f04-8cc7-4616-93f8-ac9ecc8479c8",
                    "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
                    "version" => 0,
                    "roles" => [
                        "customer" => [
                            "number" => 10308
                        ]
                    ],
                    "person" => [
                        "salutation" => "Frau",
                        "firstName" => "Inge",
                        "lastName" => "Musterfrau"
                    ],
                    "archived" => false
                ],
                [
                    "id" => "313ef116-a432-4823-9dfe-1b1200eb458a",
                    "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
                    "version" => 0,
                    "roles" => [
                        "customer" => [
                            "number" => 10309
                        ]
                    ],
                    "person" => [
                        "salutation" => "Herr",
                        "firstName" => "Max",
                        "lastName" => "Mustermann"
                    ],
                    "archived" => true
                ]
            ],
        ];


        $contacts = new Contacts($data);
        $this->assertInstanceOf(Contacts::class, $contacts);
        $this->assertIsArray($contacts->getValues());
        $this->assertInstanceOf(Contact::class, $contacts->getValues()[0]);
        $this->assertInstanceOf(Contact::class, $contacts->getValues()[1]);
        $this->assertEquals('Inge', $contacts->getValues()[0]->person->firstName);
        $this->assertEquals('Mustermann', $contacts->getValues()[1]->person->lastName);
    }

    public function testCreateContactsPage() {
        $data = [
            "content" => [
                [
                    "id" => "e9066f04-8cc7-4616-93f8-ac9ecc8479c8",
                    "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
                    "version" => 0,
                    "roles" => [
                        "customer" => [
                            "number" => 10308
                        ]
                    ],
                    "person" => [
                        "salutation" => "Frau",
                        "firstName" => "Inge",
                        "lastName" => "Musterfrau"
                    ],
                    "archived" => false
                ],
                [
                    "id" => "313ef116-a432-4823-9dfe-1b1200eb458a",
                    "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
                    "version" => 0,
                    "roles" => [
                        "customer" => [
                            "number" => 10309
                        ]
                    ],
                    "person" => [
                        "salutation" => "Herr",
                        "firstName" => "Max",
                        "lastName" => "Mustermann"
                    ],
                    "archived" => true
                ]
            ],
            "totalPages" => 1,
            "totalElements" => 2,
            "last" => true,
            "sort" => [
                [
                    "direction" => "ASC",
                    "property" => "name",
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


        $contactsPage = new ContactsPage($data);
        $this->assertInstanceOf(ContactsPage::class, $contactsPage);
        $this->assertInstanceOf(Contacts::class, $contactsPage->getContent());
        $this->assertInstanceOf(Contact::class, $contactsPage->getValues()[0]);
    }
}
