<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contact;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class EmailAddressList extends NamedValueList {
    public function __construct($data = null) {
        $this->className = EmailAddress::class;
        parent::__construct($data);
    }
}
