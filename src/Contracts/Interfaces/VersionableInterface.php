<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

use Lexoffice\Entities\Version;

interface VersionableInterface {
    public function getVersion(): ?Version;
}
