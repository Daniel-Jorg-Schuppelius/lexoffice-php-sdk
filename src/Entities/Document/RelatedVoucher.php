<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\ID;

class RelatedVoucher extends NamedEntity {
    protected ID $id;
    protected string $voucherNumber;
    protected string $voucherType;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
