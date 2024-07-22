<?php

declare(strict_types=1);

namespace Lexoffice\Entities\DownPaymentInvoices;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Document\ExtendedLineItems;
use Lexoffice\Entities\Document\PaymentConditions;
use Lexoffice\Entities\Document\ShippingConditions;

class DownPaymentInvoices extends NamedDocument {
    public DateTime $dueDate;
    public ExtendedLineItems $lineItems;
    public PaymentConditions $paymentConditions;
    public ShippingConditions $shippingConditions;
    public ClosingInvoiceID $closingInvoiceId;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
