<?php

declare(strict_types=1);

namespace Lexoffice\Enums;

enum BusinessFeatureType: string {
    case INVOICING = 'INVOICING';
    case INVOICING_PRO = 'INVOICING_PRO';
    case BOOKKEEPING = 'BOOKKEEPING';
}
