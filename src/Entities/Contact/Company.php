<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contact;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;

class Company extends NamedEntity {
    public bool $allowTaxFreeInvoices;
    public string $name;
    public string $taxNumber;
    public string $vatRegistrationId;
    public ContactPersons $contactPersons;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
