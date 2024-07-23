<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedValue;

class PhoneNumber extends NamedValue {
    public function __construct($data = null) {
        parent::__construct($data);
    }
}
