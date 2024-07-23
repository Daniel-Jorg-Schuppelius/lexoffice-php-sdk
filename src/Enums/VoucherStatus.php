<?php

declare(strict_types=1);

namespace Lexoffice\Enums;

enum VoucherStatus: string {
    case DRAFT = 'draft';
    case OPEN = 'open';
    case PAID = 'paid';
    case PAIDOFF = 'paidoff';
    case VOIDED = 'voided';
    case TRANSFERRED = 'transferred';
    case SEPADEBIT = 'sepadebit';
}
