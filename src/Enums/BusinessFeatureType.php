<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : BusinessFeatureType.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Enums;

enum BusinessFeatureType: string {
    case INVOICING = 'INVOICING';
    case INVOICING_PRO = 'INVOICING_PRO';
    case BOOKKEEPING = 'BOOKKEEPING';
}
