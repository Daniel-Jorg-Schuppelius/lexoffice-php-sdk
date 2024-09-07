<?php

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