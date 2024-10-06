<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DownPaymentDeduction.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Invoices;

use DateTime;
use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Entities\ID;
use Psr\Log\LoggerInterface;

class DownPaymentDeduction extends NamedEntity {
    protected ID $id;
    protected string $voucherType;
    protected string $title;
    protected string $voucherNumber;
    protected DateTime $voucherDate;
    protected float $receivedGrossAmount;
    protected float $receivedNetAmount;
    protected float $receivedTaxAmount;
    protected float $taxRatePercentage;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getId(): ID {
        return $this->id;
    }

    public function getVoucherType(): string {
        return $this->voucherType;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getVoucherNumber(): string {
        return $this->voucherNumber;
    }

    public function getVoucherDate(): DateTime {
        return $this->voucherDate;
    }

    public function getReceivedGrossAmount(): float {
        return $this->receivedGrossAmount;
    }

    public function getReceivedNetAmount(): float {
        return $this->receivedNetAmount;
    }

    public function getReceivedTaxAmount(): float {
        return $this->receivedTaxAmount;
    }

    public function getTaxRatePercentage(): float {
        return $this->taxRatePercentage;
    }
}
