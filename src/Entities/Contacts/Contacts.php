<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class Contacts extends NamedValueList {
    public function __construct($data = null) {
        $this->entityName = "content";
        $this->className = Contact::class;

        parent::__construct($data);
    }
}
