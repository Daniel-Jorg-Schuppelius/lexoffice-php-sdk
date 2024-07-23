<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class Roles extends NamedEntity {
    protected Role $customer;
    protected Role $vendor;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
