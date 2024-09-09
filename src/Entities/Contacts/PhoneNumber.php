<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Entities\Contact\PhoneNumber as ContactPhoneNumber;
use Psr\Log\LoggerInterface;

class PhoneNumber extends ContactPhoneNumber {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = 'phoneNumber';
        parent::__construct($data, $logger);
    }
}
