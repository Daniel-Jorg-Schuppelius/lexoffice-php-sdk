<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PrintLayouts;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class PrintLayouts extends NamedValueList {
    public function __construct($data = null) {
        $this->className = PrintLayout::class;
        parent::__construct($data);
    }
}
