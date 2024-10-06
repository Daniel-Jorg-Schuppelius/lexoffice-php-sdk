<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ExecutionStatus.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Enums;

enum ExecutionStatus: string {
    case ACTIVE = 'ACTIVE';
    case PAUSED = 'PAUSED';
    case ENDED = 'ENDED';
}
