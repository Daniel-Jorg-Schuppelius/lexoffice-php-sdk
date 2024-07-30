<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedValues;

class PhoneNumberList extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = PhoneNumber::class;
        parent::__construct($data);
    }
}
