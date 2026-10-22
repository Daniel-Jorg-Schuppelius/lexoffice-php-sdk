<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ClosingInvoiceID.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\DownPaymentInvoices;

use Lexoffice\Contracts\Abstracts\UuidID;
use Psr\Log\LoggerInterface;

class ClosingInvoiceID extends UuidID {
    /**
     * @param mixed $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = 'closingInvoiceId';
        parent::__construct($data, $logger);
    }
}
