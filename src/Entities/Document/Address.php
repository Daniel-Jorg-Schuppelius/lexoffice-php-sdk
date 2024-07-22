<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\ContactID;
use Lexoffice\Enums\CountryCode;

class Address extends NamedEntity {
    protected ContactID $contactId;
    protected string $name;
    protected string $supplement;
    public string $street;
    public string $city;
    public string $zip;
    public CountryCode $countryCode;
    public ContactID $contactPerson;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
