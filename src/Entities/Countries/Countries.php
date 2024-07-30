<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Countries;

use Lexoffice\Contracts\Abstracts\NamedValues;

class Countries extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = Country::class;
        parent::__construct($data);
    }
}
