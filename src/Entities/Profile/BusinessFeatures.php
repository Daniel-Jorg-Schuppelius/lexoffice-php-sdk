<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use Lexoffice\Contracts\Abstracts\NamedValues;

class BusinessFeatures extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = BusinessFeature::class;
        parent::__construct($data);
    }
}
