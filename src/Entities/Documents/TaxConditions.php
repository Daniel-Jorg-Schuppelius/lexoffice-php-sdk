<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\TaxSubType;
use Lexoffice\Enums\TaxType;
use Psr\Log\LoggerInterface;

class TaxConditions extends NamedEntity {
    protected TaxType $taxType;
    protected ?TaxSubType $taxSubType;
    protected ?string $taxTypeNote;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getTaxType(): TaxType {
        return $this->taxType;
    }

    public function getTaxSubType(): ?TaxSubType {
        return $this->taxSubType;
    }

    public function getTaxTypeNote(): ?string {
        return $this->taxTypeNote;
    }

    public function setTaxType(TaxType $taxType): void {
        $this->taxType = $taxType;
    }
}
