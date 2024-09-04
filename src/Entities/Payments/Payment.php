<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Payments;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\Payments\PaymentItems;
use Lexoffice\Enums\Currency;
use Lexoffice\Enums\PaymentStatus;
use Lexoffice\Enums\VoucherStatus;
use Lexoffice\Enums\VoucherType;
use Psr\Log\LoggerInterface;

class Payment extends NamedEntity {
    protected float $openAmount;
    protected Currency $currency;
    protected PaymentStatus $paymentStatus;
    protected VoucherType $voucherType;
    protected VoucherStatus $voucherStatus;
    protected DateTime $paidDate;
    protected PaymentItems $paymentItems;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getOpenAmount(): float {
        return $this->openAmount;
    }

    public function getCurrency(): Currency {
        return $this->currency;
    }

    public function getPaymentStatus(): PaymentStatus {
        return $this->paymentStatus;
    }

    public function getVoucherType(): VoucherType {
        return $this->voucherType;
    }

    public function getVoucherStatus(): VoucherStatus {
        return $this->voucherStatus;
    }

    public function getPaidDate(): DateTime {
        return $this->paidDate;
    }

    public function getPaymentItems(): PaymentItems {
        return $this->paymentItems;
    }
}
