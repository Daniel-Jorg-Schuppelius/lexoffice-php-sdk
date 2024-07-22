<?php

declare(strict_types=1);

namespace Lexoffice\Enums;

enum TaxClassification: string {
    case GERMANY = 'de';
    case INTRACOMMUNITY = 'intraCommunity';
    case THIRDPARTYCOUNTRY = 'thirdPartyCountry';
}
