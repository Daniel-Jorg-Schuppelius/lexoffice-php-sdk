<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Payment.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Payments;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use CommonToolkit\Enums\CurrencyCode;
use CommonToolkit\ValueObjects\Money;
use DateTime;
use Lexoffice\Enums\{PaymentStatus, VoucherStatus, VoucherType};
use Lexoffice\Traits\MoneyAccessorTrait;
use Psr\Log\LoggerInterface;

class Payment extends NamedEntity {
    use MoneyAccessorTrait;

    protected float $openAmount;
    protected CurrencyCode $currency;
    protected PaymentStatus $paymentStatus;
    protected VoucherType $voucherType;
    protected VoucherStatus $voucherStatus;
    protected DateTime $paidDate;
    protected PaymentItems $paymentItems;

    /**
     * @param array<string, mixed>|object|null $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getOpenAmount(): Money {
        return $this->toMoney($this->openAmount) ?? Money::zero($this->entityCurrency());
    }

    public function getCurrency(): CurrencyCode {
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
