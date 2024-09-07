<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use Lexoffice\Contracts\Abstracts\ResourceAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;

class VoucherResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new Voucher();
    }
}
