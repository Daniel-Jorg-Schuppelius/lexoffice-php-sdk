<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class LineItems extends NamedValueList {
    public function __construct($data = null) {
        $this->className = LineItem::class;
        parent::__construct($data);
    }
}
