<?php
/*
 * Created on   : Wed Oct 21 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : AddressTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Entities\Documents;

use CommonToolkit\Enums\CountryCode;
use Lexoffice\Entities\Contacts\ContactID as ContactsContactID;
use Lexoffice\Entities\Documents\{Address, ContactID};
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase {
    private const CONTACT_ID = 'be9475f4-ef80-442b-8ab9-3ab8b1a2aeb9';

    /** Bis v1.3.2 war jede UUID als Kontakt-ID ungültig. */
    public function test_contact_id_alone_is_valid(): void {
        $address = Address::fromArray(['contactId' => self::CONTACT_ID]);

        $this->assertTrue($address->isValid());
        $this->assertSame(['contactId' => self::CONTACT_ID], $address->toArray());
    }

    public function test_malformed_contact_id_is_invalid(): void {
        $this->assertFalse(Address::fromArray(['contactId' => '4711'])->isValid());
    }

    /** Bis v1.3.2 ging ohne Angabe `countryCode: DE` hinaus. */
    public function test_missing_country_code_is_not_sent(): void {
        $address = Address::fromArray(['contactId' => self::CONTACT_ID]);

        $this->assertFalse($address->hasCountryCode());
        $this->assertArrayNotHasKey('countryCode', $address->toArray());

        $address->setCountryCode(CountryCode::Austria);
        $this->assertTrue($address->hasCountryCode());
        $this->assertSame('AT', $address->toArray()['countryCode']);
    }

    /** Eine einmalige Adresse braucht laut API Name und Land. */
    public function test_one_time_address_needs_name_and_country(): void {
        $this->assertFalse(Address::fromArray(['name' => 'Bike & Ride GmbH & Co. KG', 'city' => 'Freiburg'])->isValid());

        $address = Address::fromArray(['name' => 'Bike & Ride GmbH & Co. KG', 'zip' => '79112', 'city' => 'Freiburg', 'countryCode' => 'DE']);
        $this->assertTrue($address->isValid());
        $this->assertSame('DE', $address->toArray()['countryCode']);
    }

    public function test_set_contact_id_accepts_the_contact_resource_id(): void {
        $address = new Address(['name' => 'X', 'countryCode' => 'DE']);
        $address->setContactId(new ContactsContactID(self::CONTACT_ID));

        $this->assertInstanceOf(ContactID::class, $address->getContactId());
        $this->assertSame(self::CONTACT_ID, $address->toArray()['contactId']);
    }

    /** Laut API ein Name, bis v1.3.2 als `{"contactId": …}` modelliert. */
    public function test_contact_person_is_a_string(): void {
        $address = Address::fromArray(['contactId' => self::CONTACT_ID, 'contactPerson' => 'Herr Max Mustermann']);

        $this->assertSame('Herr Max Mustermann', $address->getContactPerson());
        $this->assertSame('Herr Max Mustermann', $address->toArray()['contactPerson']);
    }
}
