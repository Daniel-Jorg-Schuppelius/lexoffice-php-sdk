<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\OrderConfirmations;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\PaymentConditions;
use Lexoffice\Entities\Documents\ShippingConditions;
use Psr\Log\LoggerInterface;

class OrderConfirmation extends NamedDocument {
    protected ExtendedLineItems $lineItems;
    protected PaymentConditions $paymentConditions;
    protected ShippingConditions $shippingConditions;
    protected string $deliveryTerms;

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

    public function getPaymentConditions(): PaymentConditions {
        return $this->paymentConditions;
    }

    public function getShippingConditions(): ShippingConditions {
        return $this->shippingConditions;
    }

    public function getDeliveryTerms(): string {
        return $this->deliveryTerms;
    }

    public function setLineItems(ExtendedLineItems $lineItems): void {
        $this->lineItems = $lineItems;
    }

    public function setPaymentConditions(PaymentConditions $paymentConditions): void {
        $this->paymentConditions = $paymentConditions;
    }

    public function setShippingConditions(ShippingConditions $shippingConditions): void {
        $this->shippingConditions = $shippingConditions;
    }

    public function setDeliveryTerms(string $deliveryTerms): void {
        $this->deliveryTerms = $deliveryTerms;
    }
}
