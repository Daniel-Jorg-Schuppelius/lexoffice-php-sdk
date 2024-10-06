<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Roles.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Psr\Log\LoggerInterface;

class Roles extends NamedEntity {
    protected ?Role $customer;
    protected ?Role $vendor;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function isValid(): bool {
        return isset($this->customer) || isset($this->vendor);
    }

    public function getCustomer(): ?Role {
        return $this->customer ?? null;
    }

    public function getVendor(): ?Role {
        return $this->vendor ?? null;
    }

    public function getCustomerNumber(): ?int {
        return $this->customer->getValue();
    }

    public function getVendorNumber(): ?int {
        return $this->vendor->getValue();
    }
}
