<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\DeliveryNotes;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\ShippingConditions;
use Psr\Log\LoggerInterface;

class DeliveryNote extends NamedDocument {
    public ExtendedLineItems $lineItems;
    public ShippingConditions $shippingConditions;
    public ?string $deliveryTerms;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);

        if (!isset($this->shippingConditions)) {
            $this->shippingConditions = new ShippingConditions();
        }
    }
}
