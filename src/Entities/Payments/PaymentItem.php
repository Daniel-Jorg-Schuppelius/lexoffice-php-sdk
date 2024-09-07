<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Payments;

use DateTime;
use APIToolkit\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\Currency;
use Lexoffice\Enums\PaymentItemType;
use Psr\Log\LoggerInterface;

class PaymentItem extends NamedEntity {
    protected PaymentItemType $paymentItemType;
    protected DateTime $postingDate;
    protected float $amount;
    protected Currency $currency;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getPaymentItemType(): PaymentItemType {
        return $this->paymentItemType;
    }

    public function getPostingDate(): DateTime {
        return $this->postingDate;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function getCurrency(): Currency {
        return $this->currency;
    }
}
