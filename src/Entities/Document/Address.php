<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Entities\ContactID;

class Address extends \Lexoffice\Entities\Address {
    protected ?ContactID $contactId;
    protected string $name;
    public ContactID $contactPerson;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
