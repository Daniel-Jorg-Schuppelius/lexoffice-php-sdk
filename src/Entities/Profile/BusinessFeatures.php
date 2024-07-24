<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class BusinessFeatures extends NamedValueList {
    public function __construct($data = null) {
        $this->className = BusinessFeature::class;
        parent::__construct($data);
    }
}
