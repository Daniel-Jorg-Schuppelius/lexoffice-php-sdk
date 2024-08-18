<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Psr\Log\LoggerInterface;

class Address extends \Lexoffice\Entities\Address {
    protected ?ContactID $contactId;
    public string $name;
    protected ?ContactID $contactPerson;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
