<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class Contacts extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = "content";
        $this->valueClassName = Contact::class;

        parent::__construct($data, $logger);
    }
}
