<?php

declare(strict_types=1);

namespace Lexoffice\Entities\CreditNotes;

use Lexoffice\Contracts\Abstracts\NamedDocument;

class CreditNotes extends NamedDocument {
    public function __construct($data = null) {
        parent::__construct($data);
    }
}
