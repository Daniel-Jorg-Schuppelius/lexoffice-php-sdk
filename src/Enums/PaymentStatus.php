<?php

declare(strict_types=1);

namespace Lexoffice\Enums;

enum PaymentStatus: string {
    case BALANCED = 'balanced';
    case OPENREVENUE = 'openRevenue';
    case OPENEXPENSE = 'openExpense';
}
