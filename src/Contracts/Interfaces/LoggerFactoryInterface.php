<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

use Psr\Log\LoggerInterface;

interface LoggerFactoryInterface {
    public static function getLogger(): LoggerInterface;
}
