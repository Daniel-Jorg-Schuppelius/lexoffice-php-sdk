<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\Currency;

class TotalPrice extends NamedEntity {
    public Currency $currency;
    protected float $totalNetAmount;
    protected float $totalGrossAmount;
    protected float $totalTaxAmount;
    protected float $totalDiscountAbsolute;
    protected float $totalDiscountPercentage;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
