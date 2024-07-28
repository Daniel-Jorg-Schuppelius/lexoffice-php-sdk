<?php

declare(strict_types=1);

namespace Lexoffice\Entities;

use Lexoffice\Contracts\Abstracts\NamedValueList;
use Lexoffice\Entities\Sort;

class Collations extends NamedValueList {
    public function __construct($data = null) {
        $this->className = Sort::class;
        parent::__construct($data);
    }
}
