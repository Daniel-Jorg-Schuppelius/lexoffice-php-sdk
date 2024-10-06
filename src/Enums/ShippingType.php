<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ShippingType.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Enums;

enum ShippingType: string {
    case SERVICE = 'service';
    case SERVICEPERIOD = 'serviceperiod';
    case DELIVERY = 'delivery';
    case DELIVERYPERIOD = 'deliveryperiod';
    case NONE = 'none';
}
