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

    public function isValid(): bool {
        return isset($this->voucherDate)
            && (isset($this->address) && $this->address->isValid())
            && (isset($this->totalPrice) && $this->totalPrice->isValid())
            && (isset($this->taxConditions) && $this->taxConditions->isValid())
            && (isset($this->lineItems) && $this->lineItems->isValid());
    }
}
