<?php

declare(strict_types=1);

namespace Lexoffice\Enums;

enum ExecutionInterval: string {
    case WEEKLY = 'WEEKLY';
    case BIWEEKLY = 'BIWEEKLY';
    case MONTHLY = 'MONTHLY';
    case QUARTERLY = 'QUARTERLY';
    case BIANNUALLY = 'BIANNUALLY';
    case ANNUALLY = 'ANNUALLY';
}
