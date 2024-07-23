<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contact;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\OrganizationID;
use Lexoffice\Entities\Version;
use Lexoffice\Entities\XRechnung;

class Contact extends NamedEntity {
    protected ID $id;
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
}
