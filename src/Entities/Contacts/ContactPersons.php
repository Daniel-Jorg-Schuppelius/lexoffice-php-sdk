<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class ContactPersons extends NamedValueList {
    public function __construct($data = null) {
        $this->className = ContactPerson::class;
        parent::__construct($data);
    }
}
