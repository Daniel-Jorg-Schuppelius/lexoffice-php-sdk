<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use APIToolkit\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class LineItems extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        if (!is_subclass_of($this->valueClassName, LineItem::class)) {
            $this->valueClassName = LineItem::class;
        }
        parent::__construct($data, $logger);
    }
}
