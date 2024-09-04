<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Invoices;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\Address;
use Lexoffice\Entities\XRechnung;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\PaymentConditions;
use Lexoffice\Entities\Documents\PrintLayoutID;
use Lexoffice\Entities\Documents\ShippingConditions;
use Lexoffice\Entities\Documents\TaxConditions;
use Lexoffice\Entities\Documents\TotalPrice;
use Psr\Log\LoggerInterface;

class Invoice extends NamedDocument {
    protected ?DateTime $dueDate;
    protected ?XRechnung $xRechnung;
    protected ExtendedLineItems $lineItems;
    protected ?PaymentConditions $paymentConditions;
    protected ShippingConditions $shippingConditions;
    protected ?float $claimedGrossAmount;
    protected ?bool $closingInvoice;
    protected ?DownPaymentDeductions $downPaymentDeductions;
    protected ?RecurringTemplateID $recurringTemplateId;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function isValid(): bool {
        return isset($this->voucherDate)
            && (isset($this->address) && $this->address->isValid())
            && (isset($this->totalPrice) && $this->totalPrice->isValid())
            && (isset($this->taxConditions) && $this->taxConditions->isValid())
            && (isset($this->shippingConditions) && $this->shippingConditions->isValid())
            && (isset($this->lineItems) && $this->lineItems->isValid());
    }

    public function getDueDate(): ?DateTime {
        return $this->dueDate ?? null;
    }

    public function getXRechnung(): ?XRechnung {
        return $this->xRechnung ?? null;
    }

    public function getLineItems(): ExtendedLineItems {
        return $this->lineItems;
    }

    public function getPaymentConditions(): ?PaymentConditions {
        return $this->paymentConditions ?? null;
    }

    public function getShippingConditions(): ShippingConditions {
        return $this->shippingConditions;
    }

    public function getClaimedGrossAmount(): ?float {
        return $this->claimedGrossAmount ?? null;
    }

    public function getClosingInvoice(): ?bool {
        return $this->closingInvoice ?? false;
    }

    public function getDownPaymentDeductions(): ?DownPaymentDeductions {
        return $this->downPaymentDeductions ?? null;
    }

    public function getRecurringTemplateId(): ?RecurringTemplateID {
        return $this->recurringTemplateId ?? null;
    }

    public function setLanguage(string $language): void {
        $this->language = $language;
    }

    public function setVoucherDate(DateTime $voucherDate): void {
        $this->voucherDate = $voucherDate;
    }

    public function setAddress(Address $address): void {
        $this->address = $address;
    }

    public function setLineItems(ExtendedLineItems $lineItems): void {
        $this->lineItems = $lineItems;
    }

    public function setTotalPrice(TotalPrice $totalPrice): void {
        $this->totalPrice = $totalPrice;
    }

    public function setTaxConditions(TaxConditions $taxConditions): void {
        $this->taxConditions = $taxConditions;
    }

    public function setPaymentConditions(PaymentConditions $paymentConditions): void {
        $this->paymentConditions = $paymentConditions;
    }

    public function setShippingConditions(ShippingConditions $shippingConditions): void {
        $this->shippingConditions = $shippingConditions;
    }

    public function setRecurringTemplateId(RecurringTemplateID $recurringTemplateId): void {
        $this->recurringTemplateId = $recurringTemplateId;
    }

    public function setPrintLayoutId(PrintLayoutID $printLayoutID): void {
        $this->printLayoutId = $printLayoutID;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setIntroduction(string $introduction): void {
        $this->introduction = $introduction;
    }

    public function setRemark(string $remark): void {
        $this->remark = $remark;
    }
}
