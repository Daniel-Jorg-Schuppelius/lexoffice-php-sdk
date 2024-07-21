<?php

declare(strict_types=1);

namespace Lexoffice\Entities;

use Lexoffice\Contracts\Abstracts\NamedValue;
use Lexoffice\Contracts\Interfaces\NamedValueInterface;

class OrganizationID extends NamedValue implements NamedValueInterface {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->name = 'organizationId';
    }
}
