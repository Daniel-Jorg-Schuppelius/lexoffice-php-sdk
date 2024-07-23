<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

class ExtendedLineItems extends LineItems {
    public function __construct($data = null) {
        $this->className = ExtendedLineItem::class;
        parent::__construct($data);
    }
}
