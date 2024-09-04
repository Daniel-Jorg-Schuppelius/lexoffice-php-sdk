<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Quotations;

use Lexoffice\Entities\Documents\ExtendedLineItem;
use Psr\Log\LoggerInterface;

class QuotationLineItem extends ExtendedLineItem {
    protected QuotationLineItems $subItems;
    protected bool $alternative;
    protected bool $optional;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function isAlternative(): bool {
        return $this->alternative;
    }

    public function isOptional(): bool {
        return $this->optional;
    }

    public function getSubItems(): QuotationLineItems {
        return $this->subItems;
    }

    public function setSubItems(QuotationLineItems $subItems): void {
        $this->subItems = $subItems;
    }

    public function setAlternative(bool $alternative): void {
        $this->alternative = $alternative;
    }

    public function setOptional(bool $optional): void {
        $this->optional = $optional;
    }
}
