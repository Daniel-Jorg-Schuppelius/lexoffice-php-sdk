<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : QuotationLineItems.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Quotations;

use Lexoffice\Entities\Documents\ExtendedLineItems;
use Psr\Log\LoggerInterface;

class QuotationLineItems extends ExtendedLineItems {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = QuotationLineItem::class;
        parent::__construct($data, $logger);
    }
}
