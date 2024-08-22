<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Countries;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\CountryCode;
use Lexoffice\Enums\TaxClassification;
use Psr\Log\LoggerInterface;

class Country extends NamedEntity {
    public ?CountryCode $countryCode;
    public ?string $countryNameEN;
    public ?string $countryNameDE;
    public ?TaxClassification $taxClassification;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
