<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : XRechnung.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Psr\Log\LoggerInterface;

class XRechnung extends NamedEntity {
    protected string $buyerReference;
    protected string $vendorNumberAtCustomer;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getBuyerReference(): string {
        return $this->buyerReference;
    }

    public function getVendorNumberAtCustomer(): string {
        return $this->vendorNumberAtCustomer;
    }

    public function setBuyerReference(string $buyerReference): void {
        $this->buyerReference = $buyerReference;
    }

    public function setVendorNumberAtCustomer(string $vendorNumberAtCustomer): void {
        $this->vendorNumberAtCustomer = $vendorNumberAtCustomer;
    }
}
