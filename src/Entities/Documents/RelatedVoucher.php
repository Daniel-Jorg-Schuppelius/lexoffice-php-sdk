<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Entities\ID;
use Psr\Log\LoggerInterface;

class RelatedVoucher extends NamedEntity {
    protected ID $id;
    protected string $voucherNumber;
    protected string $voucherType;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getId(): ID {
        return $this->id;
    }

    public function getVoucherNumber(): string {
        return $this->voucherNumber;
    }

    public function getVoucherType(): string {
        return $this->voucherType;
    }
}
