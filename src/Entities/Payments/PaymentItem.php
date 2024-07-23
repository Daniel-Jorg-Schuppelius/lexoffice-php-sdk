<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Payments;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\Currency;
use Lexoffice\Enums\PaymentItemType;

class PaymentItem extends NamedEntity {
    public PaymentItemType $paymentItemType;
    public DateTime $postingDate;
    public float $amount;
    public Currency $currency;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}