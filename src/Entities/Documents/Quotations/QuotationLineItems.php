<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Quotations;

use Lexoffice\Entities\Documents\ExtendedLineItems;
use Psr\Log\LoggerInterface;

class QuotationLineItems extends ExtendedLineItems {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = QuotationLineItem::class;
        parent::__construct($data, $logger);
    }
}
