<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\LeadingPrice;
use Psr\Log\LoggerInterface;

class Price extends NamedEntity {
    public ?float $netPrice;
    public ?float $grossPrice;
    public LeadingPrice $leadingPrice;
    public float $taxRate = 0;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function isValid(): bool {
        if ($this->leadingPrice === LeadingPrice::GROSS) {
            return isset($this->grossPrice) && !is_null($this->grossPrice);
        }
        return isset($this->netPrice) && !is_null($this->netPrice);
    }
}
