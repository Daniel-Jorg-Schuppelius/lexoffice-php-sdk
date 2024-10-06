<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ExtendedLineItems.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Psr\Log\LoggerInterface;

class ExtendedLineItems extends LineItems {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        if (!is_subclass_of($this->valueClassName, ExtendedLineItem::class)) {
            $this->valueClassName = ExtendedLineItem::class;
        }
        parent::__construct($data, $logger);
    }
}
