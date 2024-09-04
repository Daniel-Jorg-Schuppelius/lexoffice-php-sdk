<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\DeliveryNotes;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\Address;
use Lexoffice\Entities\Documents\PrintLayoutID;
use Lexoffice\Entities\Documents\ShippingConditions;
use Lexoffice\Entities\Documents\TaxConditions;
use Psr\Log\LoggerInterface;

class DeliveryNote extends NamedDocument {
    protected DeliveryNoteExtendedLineItems $lineItems;
    protected ShippingConditions $shippingConditions;
    protected ?string $deliveryTerms;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);

        if (!isset($this->shippingConditions)) {
            $this->shippingConditions = new ShippingConditions();
        }
    }

    public function getLineItems(): DeliveryNoteExtendedLineItems {
        return $this->lineItems;
    }

    public function getShippingConditions(): ShippingConditions {
        return $this->shippingConditions;
    }

    public function getDeliveryTerms(): ?string {
        return $this->deliveryTerms ?? null;
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

    public function setLineItems(DeliveryNoteExtendedLineItems $lineItems): void {
        $this->lineItems = $lineItems;
    }

    public function setTaxConditions(TaxConditions $taxConditions): void {
        $this->taxConditions = $taxConditions;
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

    public function setDeliveryTerms(string $deliveryTerms): void {
        $this->deliveryTerms = $deliveryTerms;
    }
}
