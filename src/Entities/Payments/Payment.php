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
    public float $openAmount;
    public Currency $currency;
    public PaymentStatus $paymentStatus;
    public VoucherType $voucherType;
    public VoucherStatus $voucherStatus;
    public DateTime $paidDate;
    public PaymentItems $paymentItems;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
