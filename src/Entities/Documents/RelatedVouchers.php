<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class RelatedVouchers extends NamedValueList {
    public function __construct($data = null) {
        $this->className = RelatedVoucher::class;
        parent::__construct($data);
    }
}
