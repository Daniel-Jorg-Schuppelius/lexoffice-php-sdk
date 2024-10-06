<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Country.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Countries;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\CountryCode;
use Lexoffice\Enums\TaxClassification;
use Psr\Log\LoggerInterface;

class Country extends NamedEntity {
    protected ?CountryCode $countryCode;
    protected ?string $countryNameEN;
    protected ?string $countryNameDE;
    protected ?TaxClassification $taxClassification;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getCountryCode(): ?CountryCode {
        return $this->countryCode ?? null;
    }

    public function getCountryNameEN(): ?string {
        return $this->countryNameEN ?? null;
    }

    public function getCountryNameDE(): ?string {
        return $this->countryNameDE ?? null;
    }

    public function getTaxClassification(): ?TaxClassification {
        return $this->taxClassification ?? null;
    }
}
