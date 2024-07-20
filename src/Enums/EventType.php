<?php

declare(strict_types=1);

namespace Lexoffice\Enums;

enum EventType: string
{
    case ARTICLE_CREATED = 'article.created';
    case ARTICLE_CHANGED = 'article.changed';
    case ARTICLE_DELETED = 'article.deleted';

    case CONTACT_CREATED = 'contact.created';
    case CONTACT_CHANGED = 'contact.changed';
    case CONTACT_DELETED = 'contact.deleted';

    case CREDIT_NOTE_CREATED = 'credit-note.created';
    case CREDIT_NOTE_CHANGED = 'credit-note.changed';
    case CREDIT_NOTE_DELETED = 'credit-note.deleted';
    case CREDIT_NOTE_STATUS_CHANGED = 'credit-note.status.changed';

    case DELIVERY_NOTE_CREATED = 'delivery-note.created';
    case DELIVERY_NOTE_CHANGED = 'delivery-note.changed';
    case DELIVERY_NOTE_DELETED = 'delivery-note.deleted';

    case DOWN_PAYMENT_INVOICE_CREATED = 'down-payment-invoice.created';
    case DOWN_PAYMENT_INVOICE_CHANGED = 'down-payment-invoice.changed';
    case DOWN_PAYMENT_INVOICE_DELETED = 'down-payment-invoice.deleted';
    case DOWN_PAYMENT_INVOICE_STATUS_CHANGED = 'down-payment-invoice.status.changed';

    case DUNNING_CREATED = 'dunning.created';
    case DUNNING_CHANGED = 'dunning.changed';
    case DUNNING_DELETED = 'dunning.deleted';

    case INVOICE_CREATED = 'invoice.created';
    case INVOICE_CHANGED = 'invoice.changed';
    case INVOICE_DELETED = 'invoice.deleted';
    case INVOICE_STATUS_CHANGED = 'invoice.status.changed';

    case ORDER_CONFIRMATION_CREATED = 'order-confirmation.created';
    case ORDER_CONFIRMATION_CHANGED = 'order-confirmation.changed';
    case ORDER_CONFIRMATION_DELETED = 'order-confirmation.deleted';
    case ORDER_CONFIRMATION_STATUS_CHANGED = 'order-confirmation.status.changed';

    case PAYMENT_CHANGED = 'payment.changed';

    case QUOTATION_CREATED = 'quotation.created';
    case QUOTATION_CHANGED = 'quotation.changed';
    case QUOTATION_DELETED = 'quotation.deleted';
    case QUOTATION_STATUS_CHANGED = 'quotation.status.changed';

    case RECURRING_TEMPLATE_CREATED = 'recurring-template.created';
    case RECURRING_TEMPLATE_CHANGED = 'recurring-template.changed';
    case RECURRING_TEMPLATE_DELETED = 'recurring-template.deleted';

    case TOKEN_REVOKED = 'token.revoked';

    case VOUCHER_CREATED = 'voucher.created';
    case VOUCHER_CHANGED = 'voucher.changed';
    case VOUCHER_DELETED = 'voucher.deleted';
    case VOUCHER_STATUS_CHANGED = 'voucher.status.changed';
}
