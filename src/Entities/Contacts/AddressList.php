<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedValues;
use Lexoffice\Entities\Address;

class AddressList extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = Address::class;
        parent::__construct($data);
    }
}
