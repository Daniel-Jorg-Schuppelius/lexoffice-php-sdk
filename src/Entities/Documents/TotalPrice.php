<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\Currency;
use Psr\Log\LoggerInterface;

class TotalPrice extends NamedEntity {
    public Currency $currency;
    protected ?float $totalNetAmount;
    protected ?float $totalGrossAmount;
    protected ?float $totalTaxAmount;
    protected ?float $totalDiscountAbsolute;
    protected ?float $totalDiscountPercentage;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
