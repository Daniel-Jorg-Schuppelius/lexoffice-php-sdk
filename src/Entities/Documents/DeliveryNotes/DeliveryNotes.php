<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\DeliveryNotes;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\ShippingConditions;

class DeliveryNotes extends NamedDocument {
    public ExtendedLineItems $lineItems;
    public ShippingConditions $shippingConditions;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
