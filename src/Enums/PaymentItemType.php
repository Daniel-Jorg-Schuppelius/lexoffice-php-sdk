<?php

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
