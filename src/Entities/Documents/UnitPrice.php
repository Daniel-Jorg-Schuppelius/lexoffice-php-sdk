<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\Currency;
use Psr\Log\LoggerInterface;

class UnitPrice extends NamedEntity {
    public Currency $currency;
    public float $netAmount;
    public float $grossAmount;
    public float $taxRatePercentage;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
