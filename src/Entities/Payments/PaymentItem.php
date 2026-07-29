<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PaymentItem.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Payments;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Traits\MoneyAccessorTrait;
use CommonToolkit\Enums\CurrencyCode;
use CommonToolkit\ValueObjects\Money;
use DateTime;
use Lexoffice\Enums\PaymentItemType;
use Psr\Log\LoggerInterface;

class PaymentItem extends NamedEntity {
    use MoneyAccessorTrait;

    protected PaymentItemType $paymentItemType;
    protected DateTime $postingDate;
    protected float $amount;
    protected CurrencyCode $currency;

    /**
     * @param array<string, mixed>|object|null $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getPaymentItemType(): PaymentItemType {
        return $this->paymentItemType;
    }

    public function getPostingDate(): DateTime {
        return $this->postingDate;
    }

    public function getAmount(): Money {
        return $this->toMoney($this->amount) ?? Money::zero($this->entityCurrency());
    }

    public function getCurrency(): CurrencyCode {
        return $this->currency;
    }
}
