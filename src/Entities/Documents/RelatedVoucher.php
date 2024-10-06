<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : RelatedVoucher.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

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
