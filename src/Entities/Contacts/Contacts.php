<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedValues;

class Contacts extends NamedValues {
    public function __construct($data = null) {
        $this->entityName = "content";
        $this->valueClassName = Contact::class;

        parent::__construct($data);
    }
}
