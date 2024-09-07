<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PaymentConditions;

use APIToolkit\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class PaymentConditions extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = PaymentCondition::class;
        parent::__construct($data, $logger);
    }
}
