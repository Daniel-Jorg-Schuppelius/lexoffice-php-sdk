<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Price.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\LeadingPrice;
use Psr\Log\LoggerInterface;

class Price extends NamedEntity {
    protected ?float $netPrice;
    protected ?float $grossPrice;
    protected LeadingPrice $leadingPrice;
    protected float $taxRate = 0;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getNetPrice(): ?float {
        return $this->netPrice;
    }

    public function getGrossPrice(): ?float {
        return $this->grossPrice;
    }

    public function getLeadingPrice(): LeadingPrice {
        return $this->leadingPrice;
    }

    public function getTaxRate(): float {
        return $this->taxRate;
    }

    public function setNetPrice(?float $netPrice): void {
        $this->netPrice = $netPrice;
    }

    public function setGrossPrice(?float $grossPrice): void {
        $this->grossPrice = $grossPrice;
    }

    public function setLeadingPrice(LeadingPrice $leadingPrice): void {
        $this->leadingPrice = $leadingPrice;
    }

    public function setTaxRate(float $taxRate): void {
        $this->taxRate = $taxRate;
    }

    public function isValid(): bool {
        if ($this->leadingPrice === LeadingPrice::GROSS) {
            return isset($this->grossPrice) && !is_null($this->grossPrice);
        }
        return isset($this->netPrice) && !is_null($this->netPrice);
    }
}
