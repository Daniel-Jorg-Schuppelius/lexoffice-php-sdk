<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DownPaymentInvoice.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\DownPaymentInvoices;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedDocument;
use Lexoffice\Entities\Documents\ExtendedLineItems;
use Lexoffice\Entities\Documents\PaymentConditions;
use Lexoffice\Entities\Documents\ShippingConditions;
use Psr\Log\LoggerInterface;

class DownPaymentInvoice extends NamedDocument {
    protected ?DateTime $dueDate;
    protected ?ExtendedLineItems $lineItems;
    protected ?PaymentConditions $paymentConditions;
    protected ?ShippingConditions $shippingConditions;
    protected ?ClosingInvoiceID $closingInvoiceId;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getDueDate(): ?DateTime {
        return $this->dueDate ?? null;
    }

    public function getLineItems(): ?ExtendedLineItems {
        return $this->lineItems ?? null;
    }

    public function getPaymentConditions(): ?PaymentConditions {
        return $this->paymentConditions ?? null;
    }

    public function getShippingConditions(): ?ShippingConditions {
        return $this->shippingConditions ?? null;
    }

    public function getClosingInvoiceId(): ?ClosingInvoiceID {
        return $this->closingInvoiceId ?? null;
    }
}
