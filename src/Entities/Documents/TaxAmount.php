<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : TaxAmount.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Psr\Log\LoggerInterface;

class TaxAmount extends NamedEntity {
    protected float $taxRatePercentage;
    protected float $taxAmount;
    protected float $netAmount;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getTaxRatePercentage(): float {
        return $this->taxRatePercentage;
    }

    public function getTaxAmount(): float {
        return $this->taxAmount;
    }

    public function getNetAmount(): float {
        return $this->netAmount;
    }
}
