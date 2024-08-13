<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use Lexoffice\Contracts\Abstracts\NamedEntity;
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
}
