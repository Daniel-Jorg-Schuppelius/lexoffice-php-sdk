<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Contracts\Abstracts\NamedValues;

class TaxAmounts extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = TaxAmount::class;
        parent::__construct($data);
    }
}
