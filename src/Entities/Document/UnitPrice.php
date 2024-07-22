<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\Currency;

class UnitPrice extends NamedEntity {
    public Currency $currency;
    public float $netAmount;
    public float $grossAmount;
    public int $taxRatePercentage;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
