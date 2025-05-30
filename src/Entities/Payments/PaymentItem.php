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

use DateTime;
use APIToolkit\Contracts\Abstracts\NamedEntity;
use CommonToolkit\Enums\CurrencyCode;
use Lexoffice\Enums\PaymentItemType;
use Psr\Log\LoggerInterface;

class PaymentItem extends NamedEntity {
    protected PaymentItemType $paymentItemType;
    protected DateTime $postingDate;
    protected float $amount;
    protected CurrencyCode $currency;

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

    public function getCurrency(): CurrencyCode {
        return $this->currency;
    }
}
