<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Quotations;

use Lexoffice\Entities\Documents\ExtendedLineItem;
use Psr\Log\LoggerInterface;

class QuotationLineItem extends ExtendedLineItem {
    public QuotationLineItems $subItems;
    public bool $alternative;
    public bool $optional;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
