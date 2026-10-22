<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Address.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\Common\Address as CommonAddress;
use CommonToolkit\Enums\CountryCode;
use Lexoffice\Entities\Contacts\ContactID as ContactsContactID;
use Psr\Log\LoggerInterface;

/**
 * Empfängeradresse eines Verkaufsbelegs: Verweis auf einen Lexware-Kontakt
 * (`contactId`) oder einmalige Adresse (`name` + `countryCode`).
 *
 * Die Basisklasse belegt ein fehlendes Land mit DE vor. Gesendet wird das
 * Land nur, wenn es angegeben wurde — sonst überschriebe DE das Land eines
 * referenzierten Auslandskontakts.
 */
class Address extends CommonAddress {
    protected ?ContactID $contactId;
    protected ?string $name;
    /** Laut API eine Zeichenkette (Name der Kontaktperson), nur lesbar. */
    protected ?string $contactPerson;

    private bool $countryCodeGiven = false;

    /**
     * @param array<string, mixed>|object|null $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    /**
     * @param array<string, mixed>|object $data
     */
    public function setData(array|object $data): NamedEntityInterface {
        parent::setData($data);

        if (array_key_exists('countryCode', (array) $data)) {
            $this->countryCodeGiven = true;
        }

        return $this;
    }

    public function isValid(): bool {
        return (isset($this->contactId) && $this->contactId->isValid())
            || (!empty($this->name) && $this->countryCodeGiven);
    }

    public function hasCountryCode(): bool {
        return $this->countryCodeGiven;
    }

    public function getContactId(): ?ContactID {
        return $this->contactId ?? null;
    }

    public function getName(): ?string {
        return $this->name ?? null;
    }

    public function getContactPerson(): ?string {
        return $this->contactPerson ?? null;
    }

    public function setContactId(ContactsContactID $contactId): void {
        $this->contactId = $contactId instanceof ContactID ? $contactId : new ContactID($contactId->toString());
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setCountryCode(CountryCode $countryCode): void {
        parent::setCountryCode($countryCode);
        $this->countryCodeGiven = true;
    }

    /**
     * @return array<string, array{
     *     class: class-string,
     *     type: \ReflectionType|null,
     *     value: mixed,
     *     valueClass: string,
     *     visibility: array<string>,
     *     allowsNull: bool,
     *     isInitialized: bool
     * }>
     */
    protected function getEntityProperties(bool $noNullValues = false): array {
        $properties = parent::getEntityProperties($noNullValues);
        unset($properties['countryCodeGiven']);

        if (!$this->countryCodeGiven) {
            unset($properties['countryCode']);
        }

        return $properties;
    }
}
