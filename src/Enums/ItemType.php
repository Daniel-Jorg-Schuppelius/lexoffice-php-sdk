<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ItemType.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Enums;

enum ItemType: string {
    case SERVICE = 'service';
    case MATERIAL = 'material';
    case CUSTOM = 'custom';
    case TEXT = 'text';
}
