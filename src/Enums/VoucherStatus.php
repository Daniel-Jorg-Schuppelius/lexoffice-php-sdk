<?php

declare(strict_types=1);

namespace Lexoffice\Enums;

enum VoucherStatus: string {
    case DRAFT = 'draft';
    case OPEN = 'open';
    case PAIDOFF = 'paidoff';
    case VOIDED = 'voided';
}
