<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Entities\ID;
use Psr\Log\LoggerInterface;

class ContactID extends ID {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
        $this->entityName = 'contactId';
    }
}