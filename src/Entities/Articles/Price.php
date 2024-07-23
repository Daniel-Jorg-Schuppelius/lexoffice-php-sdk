<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\LeadingPrice;

class Price extends NamedEntity {
    protected float $netPrice;
    protected float $grossPrice;
    protected LeadingPrice $leadingPrice;
    protected int $taxRate;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
