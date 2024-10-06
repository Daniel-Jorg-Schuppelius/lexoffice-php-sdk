<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PaymentCondition.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\PaymentConditions;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\IdentifiableNamedEntityInterface;
use APIToolkit\Entities\ID;
use Psr\Log\LoggerInterface;

class PaymentCondition extends NamedEntity implements IdentifiableNamedEntityInterface {
    protected ID $id;
    protected bool $organizationDefault;
    protected string $paymentTermLabelTemplate;
    protected int $paymentTermDuration;
    protected ?PaymentDiscountConditions $paymentDiscountConditions;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): ID {
        return $this->id;
    }

    public function getPaymentTermLabelTemplate(): string {
        return $this->paymentTermLabelTemplate;
    }

    public function getPaymentTermDuration(): int {
        return $this->paymentTermDuration;
    }

    public function getPaymentDiscountConditions(): ?PaymentDiscountConditions {
        return $this->paymentDiscountConditions;
    }

    public function setOrganizationDefault(bool $organizationDefault): void {
        $this->organizationDefault = $organizationDefault;
    }

    public function setPaymentTermLabelTemplate(string $paymentTermLabelTemplate): void {
        $this->paymentTermLabelTemplate = $paymentTermLabelTemplate;
    }

    public function setPaymentTermDuration(int $paymentTermDuration): void {
        $this->paymentTermDuration = $paymentTermDuration;
    }

    public function setPaymentDiscountConditions(?PaymentDiscountConditions $paymentDiscountConditions): void {
        $this->paymentDiscountConditions = $paymentDiscountConditions;
    }

    public function isOrganizationDefault(): bool {
        return $this->organizationDefault;
    }
}
