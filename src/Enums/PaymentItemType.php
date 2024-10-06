<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PaymentItemType.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Enums;

enum PaymentItemType: string {
    case PARTYPAYMENTFINANCIALTRANSACTION = 'partPaymentFinancialTransaction';
    case PARTPAYMENTCREDITNOTE = 'partPaymentCreditNote';
    case PARTPAYMENTCASHBOX = 'partPaymentCashBox';
    case MANUALPAYMENT = 'manualPayment';
    case CASHDISCOUNT = 'cashDiscount';
    case DUNNINGCOSTS = 'dunningCosts';
    case CURRENCYCONVERSION = 'currencyConversion';
}
