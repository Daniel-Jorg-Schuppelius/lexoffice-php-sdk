<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Addresses.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Psr\Log\LoggerInterface;

class Addresses extends NamedEntity {
    protected ?AddressList $billing;
    protected ?AddressList $shipping;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getBilling(): ?AddressList {
        return $this->billing ?? null;
    }

    public function getShipping(): ?AddressList {
        return $this->shipping ?? null;
    }

    public function setBilling(AddressList $billing): void {
        $this->billing = $billing;
    }

    public function setShipping(AddressList $shipping): void {
        $this->shipping = $shipping;
    }
}
