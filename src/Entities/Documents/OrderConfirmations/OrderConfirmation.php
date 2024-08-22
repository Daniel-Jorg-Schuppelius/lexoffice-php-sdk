<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\OrderConfirmations;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\PaymentConditions;
use Lexoffice\Entities\Documents\ShippingConditions;
use Psr\Log\LoggerInterface;

class OrderConfirmation extends NamedDocument {
    public ExtendedLineItems $lineItems;
    public PaymentConditions $paymentConditions;
    public ShippingConditions $shippingConditions;
    public string $deliveryTerms;

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
}
