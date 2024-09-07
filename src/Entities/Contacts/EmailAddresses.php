<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Psr\Log\LoggerInterface;

class EmailAddresses extends NamedEntity {
    protected ?EmailAddressList $business;
    protected ?EmailAddressList $office;
    protected ?EmailAddressList $private;
    protected ?EmailAddressList $other;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
