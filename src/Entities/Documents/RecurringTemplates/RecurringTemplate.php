<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\RecurringTemplates;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\XRechnung;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\PaymentConditions;
use Lexoffice\Entities\Documents\ShippingConditions;

class RecurringTemplate extends NamedDocument {
    public ?DateTime $dueDate;
    public ?XRechnung $xRechnung;
    public ExtendedLineItems $lineItems;
    public PaymentConditions $paymentConditions;
    public ShippingConditions $shippingConditions;
    protected RecurringTemplateSettings $recurringTemplateSettings;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
