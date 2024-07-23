<?php

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
