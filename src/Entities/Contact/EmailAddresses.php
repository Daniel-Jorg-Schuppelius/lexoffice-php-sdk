<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contact;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class EmailAddresses extends NamedEntity {
    protected EmailAddressList $business;
    protected EmailAddressList $office;
    protected EmailAddressList $private;
    protected EmailAddressList $other;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
