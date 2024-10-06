<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Vouchers.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use APIToolkit\Contracts\Abstracts\NamedValues;
use Lexoffice\Entities\Vouchers\Voucher;
use Psr\Log\LoggerInterface;

class Vouchers extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = "content";
        $this->valueClassName = Voucher::class;

        parent::__construct($data, $logger);
    }
}
