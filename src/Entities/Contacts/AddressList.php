<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedValueList;
use Lexoffice\Entities\Address;

class AddressList extends NamedValueList {
    public function __construct($data = null) {
        $this->className = Address::class;
        parent::__construct($data);
    }
}
