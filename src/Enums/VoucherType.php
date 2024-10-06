<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : VoucherType.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Enums;

enum VoucherType: string {
    case SALESINVOICE = 'salesinvoice';
    case SALESCREDITNOTE = 'salescreditnote';
    case PURCHASEINVOICE = 'purchaseinvoice';
    case PURCHASECREDITNOTE = 'purchasecreditnote';
    case INVOICE = 'invoice';
    case DOWNPAYMENTINVOICE = 'downpaymentinvoice';
    case CREDITNOTE = 'creditnote';
}
