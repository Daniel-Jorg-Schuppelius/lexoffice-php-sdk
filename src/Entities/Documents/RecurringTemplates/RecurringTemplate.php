<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : RecurringTemplate.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\RecurringTemplates;

use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\PaymentConditions;
use Lexoffice\Entities\Documents\ShippingConditions;
use Psr\Log\LoggerInterface;

class RecurringTemplate extends NamedDocument {
    protected ExtendedLineItems $lineItems;
    protected PaymentConditions $paymentConditions;
    protected ShippingConditions $shippingConditions;
    protected RecurringTemplateSettings $recurringTemplateSettings;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getExtendedLineItems(): ExtendedLineItems {
        return $this->lineItems;
    }

    public function getPaymentConditions(): PaymentConditions {
        return $this->paymentConditions;
    }

    public function getShippingConditions(): ShippingConditions {
        return $this->shippingConditions;
    }

    public function getRecurringTemplateSettings(): RecurringTemplateSettings {
        return $this->recurringTemplateSettings;
    }

    public function setExtendedLineItems(ExtendedLineItems $lineItems): void {
        $this->lineItems = $lineItems;
    }

    public function setPaymentConditions(PaymentConditions $paymentConditions): void {
        $this->paymentConditions = $paymentConditions;
    }

    public function setShippingConditions(ShippingConditions $shippingConditions): void {
        $this->shippingConditions = $shippingConditions;
    }
}
