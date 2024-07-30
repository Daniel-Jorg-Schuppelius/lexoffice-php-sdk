<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PrintLayouts;

use Lexoffice\Contracts\Abstracts\NamedValues;

class PrintLayouts extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = PrintLayout::class;
        parent::__construct($data);
    }
}
