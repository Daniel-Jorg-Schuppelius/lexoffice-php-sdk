<?php

declare(strict_types=1);

namespace Lexoffice\Entities;

use Lexoffice\Contracts\Abstracts\NamedValues;
use Lexoffice\Entities\Sort;

class Collations extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = Sort::class;
        parent::__construct($data);
    }
}
