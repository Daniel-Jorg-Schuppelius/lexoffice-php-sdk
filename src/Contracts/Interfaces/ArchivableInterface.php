<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

interface ArchivableInterface {
    public function isArchived(): bool;
}
