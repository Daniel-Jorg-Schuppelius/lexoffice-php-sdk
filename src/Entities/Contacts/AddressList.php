<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Contracts\Abstracts\NamedValues;
use APIToolkit\Entities\Common\Address;
use Psr\Log\LoggerInterface;

class AddressList extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = Address::class;
        parent::__construct($data, $logger);
    }
}
