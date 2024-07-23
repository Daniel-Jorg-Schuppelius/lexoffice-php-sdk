<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\OrderConfirmations;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\PaymentConditions;
use Lexoffice\Entities\Documents\ShippingConditions;

class OrderConfirmations extends NamedDocument {
    public ExtendedLineItems $lineItems;
    public PaymentConditions $paymentConditions;
    public ShippingConditions $shippingConditions;
    public string $deliveryTerms;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
