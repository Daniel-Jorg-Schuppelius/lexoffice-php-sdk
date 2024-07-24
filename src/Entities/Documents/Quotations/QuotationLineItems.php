<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Quotations;

use Lexoffice\Entities\Documents\ExtendedLineItems;

class QuotationLineItems extends ExtendedLineItems {
    public function __construct($data = null) {
        $this->className = QuotationLineItem::class;
        parent::__construct($data);
    }
}
