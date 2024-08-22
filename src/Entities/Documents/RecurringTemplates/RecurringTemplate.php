<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\RecurringTemplates;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\PaymentConditions;
use Lexoffice\Entities\Documents\ShippingConditions;
use Psr\Log\LoggerInterface;

class RecurringTemplate extends NamedDocument {
    public ExtendedLineItems $lineItems;
    public PaymentConditions $paymentConditions;
    public ShippingConditions $shippingConditions;
    protected RecurringTemplateSettings $recurringTemplateSettings;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
