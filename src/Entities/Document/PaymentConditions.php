<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\PaymentDiscountConditions;

class PaymentConditions extends NamedEntity {
    public string $paymentTermLabel;
    protected string $paymentTermLabelTemplate;
    public int $paymentTermDuration;
    public PaymentDiscountConditions $paymentDiscountConditions;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
