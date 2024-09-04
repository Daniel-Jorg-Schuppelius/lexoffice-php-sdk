<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Quotations;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\PaymentConditions;
use Psr\Log\LoggerInterface;

class Quotation extends NamedDocument {
    protected DateTime $expirationDate;
    protected QuotationLineItems $lineItems;
    protected PaymentConditions $paymentConditions;

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

    public function getExpirationDate(): DateTime {
        return $this->expirationDate;
    }

    public function getLineItems(): QuotationLineItems {
        return $this->lineItems;
    }

    public function getPaymentConditions(): PaymentConditions {
        return $this->paymentConditions;
    }

    public function setExpirationDate(DateTime $expirationDate): void {
        $this->expirationDate = $expirationDate;
    }

    public function setLineItems(QuotationLineItems $lineItems): void {
        $this->lineItems = $lineItems;
    }

    public function setPaymentConditions(PaymentConditions $paymentConditions): void {
        $this->paymentConditions = $paymentConditions;
    }
}
