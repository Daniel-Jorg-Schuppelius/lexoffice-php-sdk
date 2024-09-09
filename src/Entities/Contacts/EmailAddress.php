<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Entities\Contact\EmailAddress as ContactEmailAddress;
use Psr\Log\LoggerInterface;

class EmailAddress extends ContactEmailAddress {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = 'emailAddress';
        parent::__construct($data, $logger);
    }
}
