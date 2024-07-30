<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Contracts\Abstracts\NamedValues;

class LineItems extends NamedValues {
    public function __construct($data = null) {
        if (!is_subclass_of($this->valueClassName, LineItem::class)) {
            $this->valueClassName = LineItem::class;
        }
        parent::__construct($data);
    }
}
