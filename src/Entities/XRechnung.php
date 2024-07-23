<?php

declare(strict_types=1);

namespace Lexoffice\Entities;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class XRechnung extends NamedEntity {
    public string $buyerReference;
    public string $vendorNumberAtCustomer;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
