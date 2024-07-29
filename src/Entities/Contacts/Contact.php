<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableInterface;
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Entities\Version;
use Lexoffice\Entities\XRechnung;

class Contact extends NamedEntity implements IdentifiableInterface, OrganizationIdentifiableInterface {
    protected ContactID $id;
    protected OrganizationID $organizationId;
    protected Version $version;
    public Roles $roles;
    public Company $company;
    public Person $person;
    public Addresses $addresses;
    public XRechnung $xRechnung;
    public EmailAddresses $emailAddresses;
    public PhoneNumbers $phoneNumbers;
    public string $note;
    protected bool $archived;

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getID(): ContactID {
        return $this->id;
    }

    public function getOrganizationID(): OrganizationID {
        return $this->organizationId;
    }

    public function getPerson(): Person {
        return $this->person;
    }
}
