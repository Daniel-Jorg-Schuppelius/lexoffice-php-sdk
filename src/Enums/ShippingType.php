<?php

declare(strict_types=1);

namespace Lexoffice\Enums;

enum ShippingType: string {
    case SERVICE = 'service';
    case SERVICEPERIOD = 'serviceperiod';
    case DELIVERY = 'delivery';
    case DELIVERYPERIOD = 'deliveryperiod';
    case NONE = 'none';
}
