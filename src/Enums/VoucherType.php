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

/**
 * Belegarten von Belegliste, Buchungsbeleg und Zahlungen. Lexware kündigt
 * weitere Arten an; lesende Felder sind deshalb nullbar.
 */
enum VoucherType: string {
    case SALESINVOICE = 'salesinvoice';
    case SALESCREDITNOTE = 'salescreditnote';
    case PURCHASEINVOICE = 'purchaseinvoice';
    case PURCHASECREDITNOTE = 'purchasecreditnote';
    case INVOICE = 'invoice';
    case DOWNPAYMENTINVOICE = 'downpaymentinvoice';
    case CREDITNOTE = 'creditnote';
    case ORDERCONFIRMATION = 'orderconfirmation';
    case QUOTATION = 'quotation';
    case DELIVERYNOTE = 'deliverynote';
    /** Nicht in der API-Referenz; von der workDiary-Anbindung gemeldet. */
    case DOWNPAYMENTDEDUCTION = 'downpaymentdeduction';
    /** Nicht in der API-Referenz; von der workDiary-Anbindung gemeldet. */
    case VOUCHER = 'voucher';
}
