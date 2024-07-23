<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Entities\ID;

class ContactID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->entityName = 'contactId';
    }
}
