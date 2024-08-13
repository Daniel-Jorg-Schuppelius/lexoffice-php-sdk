<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Quotations;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\PaymentConditions;
use Psr\Log\LoggerInterface;

class Quotation extends NamedDocument {
    public DateTime $expirationDate;
    public QuotationLineItems $lineItems;
    public PaymentConditions $paymentConditions;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
