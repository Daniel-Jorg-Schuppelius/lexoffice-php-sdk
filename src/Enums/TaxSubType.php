<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : TaxSubType.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Enums;

enum TaxSubType: string {
    case DISTANCESALES = 'distanceSales';
    case ELECTRONICSERVICES = 'electronicServices';
}
