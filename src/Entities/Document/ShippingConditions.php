<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\ShippingType;

class ShippingConditions extends NamedEntity {
    public DateTime $shippingDate;
    public ?DateTime $shippingEndDate;
    public ShippingType $shippingType;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
