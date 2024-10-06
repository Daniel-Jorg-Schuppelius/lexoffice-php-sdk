<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PaymentStatus.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Enums;

enum PaymentStatus: string {
    case BALANCED = 'balanced';
    case OPENREVENUE = 'openRevenue';
    case OPENEXPENSE = 'openExpense';
}
