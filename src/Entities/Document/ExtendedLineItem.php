<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

class ExtendedLineItem extends LineItem {
    public float $discountPercentage;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
