<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Dunnings;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\Address;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\PrintLayoutID;
use Lexoffice\Entities\Documents\ShippingConditions;
use Lexoffice\Entities\Documents\TaxConditions;
use Psr\Log\LoggerInterface;

class Dunning extends NamedDocument {
    protected ExtendedLineItems $lineItems;
    protected ShippingConditions $shippingConditions;

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

    public function getLineItems(): ExtendedLineItems {
        return $this->lineItems;
    }

    public function getShippingConditions(): ShippingConditions {
        return $this->shippingConditions;
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

    public function setTaxConditions(TaxConditions $taxConditions): void {
        $this->taxConditions = $taxConditions;
    }

    public function setShippingConditions(ShippingConditions $shippingConditions): void {
        $this->shippingConditions = $shippingConditions;
    }

    public function setPrintLayoutID(PrintLayoutID $printLayoutID): void {
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
