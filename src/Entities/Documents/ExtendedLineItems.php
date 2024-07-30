<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

class ExtendedLineItems extends LineItems {
    public function __construct($data = null) {
        if (!is_subclass_of($this->valueClassName, ExtendedLineItem::class)) {
            $this->valueClassName = ExtendedLineItem::class;
        }
        parent::__construct($data);
    }
}
