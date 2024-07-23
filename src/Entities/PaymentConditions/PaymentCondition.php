<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PaymentConditions;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\PaymentDiscountConditions;

class PaymentCondition extends NamedEntity {
    protected ID $id;
    public bool $organizationDefault;
    public string $paymentTermLabelTemplate;
    public int $paymentTermDuration;
    public ?PaymentDiscountConditions $paymentDiscountConditions;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
