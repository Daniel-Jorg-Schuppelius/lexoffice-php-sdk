<?php

declare(strict_types=1);

namespace Lexoffice\Entities;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\CountryCode;
use Psr\Log\LoggerInterface;

class Address extends NamedEntity {
    public ?string $supplement;
    public string $street;
    public string $zip;
    public string $city;
    public CountryCode $countryCode;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
