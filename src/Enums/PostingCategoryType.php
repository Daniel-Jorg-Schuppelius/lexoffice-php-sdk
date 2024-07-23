<?php

declare(strict_types=1);

namespace Lexoffice\Enums;

enum PostingCategoryType: string {
    case INCOME = 'income';
    case OUTGO = 'outgo';
}
