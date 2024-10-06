<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : RecurringTemplateID.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Invoices;

use APIToolkit\Entities\ID;
use Psr\Log\LoggerInterface;

class RecurringTemplateID extends ID {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
        $this->entityName = 'recurringTemplateId';
    }
}
