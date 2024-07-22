<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Countries;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\TaxClassification;

class Countries extends NamedEntity {
    public string $countryCode;
    public string $countryNameEN;
    public string $countryNameDE;
    public TaxClassification $taxClassification;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
