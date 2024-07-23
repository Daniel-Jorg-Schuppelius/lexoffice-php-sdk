<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document\Dunnings;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Document\ExtendedLineItems;
use Lexoffice\Entities\Document\ShippingConditions;

class Dunnings extends NamedDocument {
    public ExtendedLineItems $lineItems;
    public ShippingConditions $shippingConditions;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
