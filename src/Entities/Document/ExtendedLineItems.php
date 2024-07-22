<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

class ExtendedLineItems extends LineItems {
    public function __construct($data = null) {
        $this->className = ExtendedLineItem::class;
        parent::__construct($data);
    }
}
