<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedValues;

class ContactPersons extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = ContactPerson::class;
        parent::__construct($data);
    }
}
