<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contact;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class AddressList extends NamedValueList {
    public function __construct($data = null) {
        $this->className = Address::class;
        parent::__construct($data);
    }
}
