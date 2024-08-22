<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\ShippingType;
use Psr\Log\LoggerInterface;

class ShippingConditions extends NamedEntity {
    public DateTime $shippingDate;
    public ?DateTime $shippingEndDate;
    public ShippingType $shippingType;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function isValid(): bool {
        if (isset($this->shippingType) && ($this->shippingType === ShippingType::DELIVERYPERIOD || $this->shippingType === ShippingType::SERVICEPERIOD)) {
            return isset($this->shippingDate)
                && (isset($this->shippingEndDate) && !is_null($this->shippingEndDate));
        } elseif (isset($this->shippingType) && ($this->shippingType === ShippingType::DELIVERY || $this->shippingType === ShippingType::SERVICE)) {
            return isset($this->shippingDate);
        }

        return isset($this->shippingType);
    }
}
