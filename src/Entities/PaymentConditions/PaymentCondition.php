<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PaymentConditions;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Lexoffice\Entities\ID;
use Psr\Log\LoggerInterface;

class PaymentCondition extends NamedEntity implements IdentifiableInterface {
    protected ID $id;
    public bool $organizationDefault;
    public string $paymentTermLabelTemplate;
    public int $paymentTermDuration;
    public ?PaymentDiscountConditions $paymentDiscountConditions;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): ID {
        return $this->id;
    }
}
