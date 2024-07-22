<?php

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
