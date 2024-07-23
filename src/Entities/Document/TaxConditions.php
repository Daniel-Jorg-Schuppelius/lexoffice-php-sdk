<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\TaxSubType;
use Lexoffice\Enums\TaxType;

class TaxConditions extends NamedEntity {
    public TaxType $taxType;
    protected TaxSubType $taxSubType;
    protected ?string $taxTypeNote;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
