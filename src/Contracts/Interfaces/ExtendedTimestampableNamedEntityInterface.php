<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\TimestampableNamedEntityInterface;
use DateTime;

interface ExtendedTimestampableNamedEntityInterface extends TimestampableNamedEntityInterface {
    public function getUpdatedDate(): ?DateTime;
}