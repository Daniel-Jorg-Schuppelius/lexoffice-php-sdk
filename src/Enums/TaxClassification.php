<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : TaxClassification.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Enums;

enum TaxClassification: string {
    case GERMANY = 'de';
    case INTRACOMMUNITY = 'intraCommunity';
    case THIRDPARTYCOUNTRY = 'thirdPartyCountry';
}
