<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DeliveryNoteExtendedLineItems.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

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
