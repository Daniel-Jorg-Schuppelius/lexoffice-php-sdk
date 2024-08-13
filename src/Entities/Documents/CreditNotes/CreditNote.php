<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\CreditNotes;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\LineItems;
use Psr\Log\LoggerInterface;

class CreditNote extends NamedDocument {
    public LineItems $lineItems;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
