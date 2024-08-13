<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Psr\Log\LoggerInterface;

class ContactPerson extends Person {
    public bool $primary;
    public string $emailAddress;
    public string $phoneNumber;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
