<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Psr\Log\LoggerInterface;

class Company extends NamedEntity {
    public bool $allowTaxFreeInvoices;
    public string $name;
    public string $taxNumber;
    public string $vatRegistrationId;
    public ContactPersons $contactPersons;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
