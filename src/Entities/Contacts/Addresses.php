<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class Addresses extends NamedEntity {
    protected AddressList $billing;
    protected AddressList $shipping;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
