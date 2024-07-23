<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document\Invoices;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\ID;

class DownPaymentDeduction extends NamedEntity {
    protected ID $id;
    protected string $voucherType;
    protected string $title;
    protected string $voucherNumber;
    protected DateTime $voucherDate;
    public float $receivedGrossAmount;
    public float $receivedNetAmount;
    public float $receivedTaxAmount;
    public float $taxRatePercentage;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
