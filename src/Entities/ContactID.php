<?php

declare(strict_types=1);

namespace Lexoffice\Entities;

class ContactID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->name = 'contactId';
    }
}
