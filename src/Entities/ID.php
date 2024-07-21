<?php

declare(strict_types=1);

namespace Lexoffice\Entities;

use Lexoffice\Contracts\Abstracts\NamedValue;

class ID extends NamedValue {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->name = 'id';
        $this->readOnly = true;
    }
}
