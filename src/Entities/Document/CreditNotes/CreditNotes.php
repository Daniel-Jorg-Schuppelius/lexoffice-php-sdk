<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document\CreditNotes;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Document\LineItems;

class CreditNotes extends NamedDocument {
    public LineItems $lineItems;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
