<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\CreditNotes;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\Address;
use Lexoffice\Entities\Documents\LineItems;
use Lexoffice\Entities\Documents\PrintLayoutID;
use Lexoffice\Entities\Documents\TotalPrice;
use Psr\Log\LoggerInterface;

class CreditNote extends NamedDocument {
    protected LineItems $lineItems;

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

    public function getLineItems(): LineItems {
        return $this->lineItems;
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

    public function setLineItems(LineItems $lineItems): void {
        $this->lineItems = $lineItems;
    }

    public function setTotalPrice(TotalPrice $totalPrice): void {
        $this->totalPrice = $totalPrice;
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
