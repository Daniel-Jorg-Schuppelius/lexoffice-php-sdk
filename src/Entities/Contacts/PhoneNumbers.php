<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class PhoneNumbers extends NamedEntity {
    protected PhoneNumberList $business;
    protected PhoneNumberList $office;
    protected PhoneNumberList $mobile;
    protected PhoneNumberList $private;
    protected PhoneNumberList $fax;
    protected PhoneNumberList $other;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}