<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : RelatedVouchers.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use APIToolkit\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class RelatedVouchers extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = RelatedVoucher::class;
        parent::__construct($data, $logger);
    }
}
