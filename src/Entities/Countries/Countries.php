<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Countries;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class Countries extends NamedValueList {
    public function __construct($data = null) {
        $this->className = Country::class;
        parent::__construct($data);
    }
}
