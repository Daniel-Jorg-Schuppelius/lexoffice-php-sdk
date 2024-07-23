<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document\Invoices;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\XRechnung;
use Lexoffice\Entities\Document\ExtendedLineItems;
use Lexoffice\Entities\Document\PaymentConditions;
use Lexoffice\Entities\Document\ShippingConditions;

class Invoices extends NamedDocument {
    public ?DateTime $dueDate;
    public ?XRechnung $xRechnung;
    public ExtendedLineItems $lineItems;
    public PaymentConditions $paymentConditions;
    public ShippingConditions $shippingConditions;
    protected ?float $claimedGrossAmount;
    protected bool $closingInvoice;
    protected ?DownPaymentDeductions $downPaymentDeductions;
    public ?RecurringTemplateID $recurringTemplateId;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
