<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : VoucherStatus.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

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
    case OVERDUE = 'overdue';
    case ACCREPTED = 'accepted';
    case REJECTED = 'rejected';
    case UNCHECKED = 'unchecked';
}
