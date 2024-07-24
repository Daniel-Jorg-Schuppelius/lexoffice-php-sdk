<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class Features extends NamedValueList {
    public function __construct($data = null) {
        $this->className = Feature::class;
        parent::__construct($data);
    }
}
