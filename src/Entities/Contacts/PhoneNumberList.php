<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class PhoneNumberList extends NamedValueList {
    public function __construct($data = null) {
        $this->className = PhoneNumber::class;
        parent::__construct($data);
    }
}
