<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Invoices;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\XRechnung;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\PaymentConditions;
use Lexoffice\Entities\Documents\ShippingConditions;
use Psr\Log\LoggerInterface;

class Invoice extends NamedDocument {
    public ?DateTime $dueDate;
    public ?XRechnung $xRechnung;
    public ExtendedLineItems $lineItems;
    public PaymentConditions $paymentConditions;
    public ShippingConditions $shippingConditions;
    protected ?float $claimedGrossAmount;
    protected bool $closingInvoice;
    protected ?DownPaymentDeductions $downPaymentDeductions;
    public ?RecurringTemplateID $recurringTemplateId;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
