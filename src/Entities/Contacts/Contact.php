<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\ArchivableNamedEntityInterface;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\IdentifiableNamedEntityInterface;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\VersionableNamedEntityInterface;
use APIToolkit\Entities\Version;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableNamedEntityInterface;
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Entities\XRechnung;
use Psr\Log\LoggerInterface;

class Contact extends NamedEntity implements IdentifiableNamedEntityInterface, OrganizationIdentifiableNamedEntityInterface, ArchivableNamedEntityInterface, VersionableNamedEntityInterface {
    protected ?ContactID $id;
    protected ?OrganizationID $organizationId;
    protected Version $version;
    protected Roles $roles;
    protected ?Company $company;
    protected ?Person $person;
    protected ?Addresses $addresses;
    protected ?XRechnung $xRechnung;
    protected ?EmailAddresses $emailAddresses;
    protected ?PhoneNumbers $phoneNumbers;
    protected ?string $note;
    protected ?bool $archived;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);

        if (is_null($this->version)) {
            $this->version = new Version(0);
        }
    }

    public function getID(): ?ContactID {
        return $this->id ?? null;
    }

    public function isValid(): bool {
        return parent::isValid() && (isset($this->person) xor isset($this->company));
    }

    public function isArchived(): bool {
        return $this->archived ?? false;
    }

    public function getOrganizationID(): ?OrganizationID {
        return $this->organizationId ?? null;
    }

    public function getVersion(): ?Version {
        return $this->version ?? null;
    }

    public function getRoles(): Roles {
        return $this->roles;
    }

    public function getCompany(): ?Company {
        return $this->company ?? null;
    }

    public function getPerson(): ?Person {
        return $this->person ?? null;
    }

    public function getAddresses(): ?Addresses {
        return $this->addresses ?? null;
    }

    public function getXRechnung(): ?XRechnung {
        return $this->xRechnung ?? null;
    }

    public function getEmailAddresses(): ?EmailAddresses {
        return $this->emailAddresses ?? null;
    }

    public function getPhoneNumbers(): ?PhoneNumbers {
        return $this->phoneNumbers ?? null;
    }

    public function getNote(): ?string {
        return $this->note ?? null;
    }

    public function setRoles(Roles $roles): void {
        $this->roles = $roles;
    }

    public function setCompany(Company $company): void {
        $this->company = $company;
    }

    public function setPerson(Person $person): void {
        $this->person = $person;
    }

    public function setAddresses(Addresses $addresses): void {
        $this->addresses = $addresses;
    }

    public function setXRechnung(XRechnung $xRechnung): void {
        $this->xRechnung = $xRechnung;
    }

    public function setEmailAddresses(EmailAddresses $emailAddresses): void {
        $this->emailAddresses = $emailAddresses;
    }

    public function setPhoneNumbers(PhoneNumbers $phoneNumbers): void {
        $this->phoneNumbers = $phoneNumbers;
    }

    public function setNote(string $note): void {
        $this->note = $note;
    }
}
