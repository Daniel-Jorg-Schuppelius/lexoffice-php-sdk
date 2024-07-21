<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contact;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class Address extends NamedEntity {
    public string $supplement;
    public string $street;
    public string $zip;
    public string $city;
    public string $countryCode;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
