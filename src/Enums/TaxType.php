<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : TaxType.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Enums;

enum TaxType: string {
    case NET = 'net';
    case GROSS = 'gross';
    case VATFREE = 'vatfree';
    case INTRACOMMUNITYSUPPLY = 'intraCommunitySupply';
    case CONSTRUCTIONSERVICE13B = 'constructionService13b';
    case EXTERNALSERVICE13B = 'externalService13b';
    case THIRDPARTYCOUNTRYSERVICE = 'thirdPartyCountryService';
    case THIRDPARTYCOUNTRYDELIVERY = 'thirdPartyCountryDelivery';
    case PHOTOVOLTAICEQUIPMENT = 'photovoltaicEquipment';
}
