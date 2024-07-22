<?php

declare(strict_types=1);

namespace Lexoffice\Enums;

enum ItemType: string {
    case SERVICE = 'service';
    case MATERIAL = 'material';
    case CUSTOM = 'custom';
    case TEXT = 'text';
}
