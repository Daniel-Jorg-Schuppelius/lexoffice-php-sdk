<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class TaxAmounts extends NamedValueList {
    public function __construct($data = null) {
        $this->className = TaxAmount::class;
        parent::__construct($data);
    }
}
