<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

use DateTime;

interface TimestampableInterface {
    public function getCreatedDate(): ?DateTime;
}
