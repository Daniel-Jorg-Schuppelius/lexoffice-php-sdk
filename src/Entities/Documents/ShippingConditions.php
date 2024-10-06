<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ShippingConditions.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use DateTime;
use APIToolkit\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\ShippingType;
use Psr\Log\LoggerInterface;

class ShippingConditions extends NamedEntity {
    protected DateTime $shippingDate;
    protected ?DateTime $shippingEndDate;
    protected ShippingType $shippingType;

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

    public function getShippingDate(): DateTime {
        return $this->shippingDate;
    }

    public function getShippingEndDate(): ?DateTime {
        return $this->shippingEndDate;
    }

    public function getShippingType(): ShippingType {
        return $this->shippingType;
    }

    public function setShippingDate(DateTime $shippingDate): void {
        $this->shippingDate = $shippingDate;
    }

    public function setShippingEndDate(DateTime $shippingEndDate): void {
        $this->shippingEndDate = $shippingEndDate;
    }

    public function setShippingType(ShippingType $shippingType): void {
        $this->shippingType = $shippingType;
    }
}
