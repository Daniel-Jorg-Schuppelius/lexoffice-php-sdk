<?php

declare(strict_types=1);

namespace Lexoffice\Enums;

enum ExecutionStatus: string {
    case ACTIVE = 'ACTIVE';
    case PAUSED = 'PAUSED';
    case ENDED = 'ENDED';
}
