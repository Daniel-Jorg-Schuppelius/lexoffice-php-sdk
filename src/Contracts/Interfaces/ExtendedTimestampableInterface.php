<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

use DateTime;

interface ExtendedTimestampableInterface extends TimestampableInterface {
    public function getUpdatedDate(): ?DateTime;
}
