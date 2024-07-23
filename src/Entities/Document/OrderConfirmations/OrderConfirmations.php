<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document\OrderConfirmations;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Document\ExtendedLineItems;
use Lexoffice\Entities\Document\PaymentConditions;
use Lexoffice\Entities\Document\ShippingConditions;

class OrderConfirmations extends NamedDocument {
    public ExtendedLineItems $lineItems;
    public PaymentConditions $paymentConditions;
    public ShippingConditions $shippingConditions;
    public string $deliveryTerms;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
