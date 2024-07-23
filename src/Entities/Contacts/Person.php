<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class Person extends NamedEntity {
    public string $salutation;
    public string $firstName;
    public string $lastName;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
