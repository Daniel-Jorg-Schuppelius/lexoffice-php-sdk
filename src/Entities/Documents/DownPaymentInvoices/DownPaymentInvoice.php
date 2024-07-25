<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\DownPaymentInvoices;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\PaymentConditions;
use Lexoffice\Entities\Documents\ShippingConditions;

class DownPaymentInvoice extends NamedDocument {
    public DateTime $dueDate;
    public ExtendedLineItems $lineItems;
    public PaymentConditions $paymentConditions;
    public ShippingConditions $shippingConditions;
    public ?ClosingInvoiceID $closingInvoiceId;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
