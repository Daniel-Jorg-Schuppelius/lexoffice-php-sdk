<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class TaxAmount extends NamedEntity {
    protected float $taxRatePercentage;
    protected float $taxAmount;
    protected float $netAmount;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
