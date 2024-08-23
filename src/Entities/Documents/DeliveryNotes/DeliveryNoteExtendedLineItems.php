<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\DeliveryNotes;

use Lexoffice\Entities\Documents\ExtendedLineItems;
use Psr\Log\LoggerInterface;

class DeliveryNoteExtendedLineItems extends ExtendedLineItems {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        if (!is_subclass_of($this->valueClassName, DeliveryNoteExtendedLineItem::class)) {
            $this->valueClassName = DeliveryNoteExtendedLineItem::class;
        }
        parent::__construct($data, $logger);
    }
}
