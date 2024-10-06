<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ExtendedLineItem.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Psr\Log\LoggerInterface;

class ExtendedLineItem extends LineItem {
    protected ?float $discountPercentage;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getDiscountPercentage(): ?float {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(?float $discountPercentage): void {
        $this->discountPercentage = $discountPercentage;
    }
}
