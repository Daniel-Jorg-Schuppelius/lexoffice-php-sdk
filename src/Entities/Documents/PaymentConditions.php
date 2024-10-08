<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PaymentConditions.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\PaymentConditions\PaymentDiscountConditions;
use Psr\Log\LoggerInterface;

class PaymentConditions extends NamedEntity {
    protected string $paymentTermLabel;
    protected ?string $paymentTermLabelTemplate;
    protected int $paymentTermDuration;
    protected PaymentDiscountConditions $paymentDiscountConditions;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getPaymentTermLabel(): string {
        return $this->paymentTermLabel;
    }

    public function getPaymentTermLabelTemplate(): ?string {
        return $this->paymentTermLabelTemplate ?? null;
    }

    public function getPaymentTermDuration(): int {
        return $this->paymentTermDuration;
    }

    public function getPaymentDiscountConditions(): PaymentDiscountConditions {
        return $this->paymentDiscountConditions;
    }

    public function setPaymentTermLabel(string $paymentTermLabel): void {
        $this->paymentTermLabel = $paymentTermLabel;
    }

    public function setPaymentTermDuration(int $paymentTermDuration): void {
        $this->paymentTermDuration = $paymentTermDuration;
    }

    public function setPaymentDiscountConditions(PaymentDiscountConditions $paymentDiscountConditions): void {
        $this->paymentDiscountConditions = $paymentDiscountConditions;
    }
}
