<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use Lexoffice\Contracts\Abstracts\NamedValues;

class Features extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = Feature::class;
        parent::__construct($data);
    }
}
