<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Dunnings;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\ShippingConditions;

class Dunning extends NamedDocument {
    public ExtendedLineItems $lineItems;
    public ShippingConditions $shippingConditions;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
