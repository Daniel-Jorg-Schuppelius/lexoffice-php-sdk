<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document\DeliveryNotes;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Document\ExtendedLineItems;
use Lexoffice\Entities\Document\ShippingConditions;

class DeliveryNotes extends NamedDocument {
    public ExtendedLineItems $lineItems;
    public ShippingConditions $shippingConditions;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
