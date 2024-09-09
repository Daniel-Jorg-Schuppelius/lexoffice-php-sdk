<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

use APIToolkit\Entities\ID;

interface IdentifiableInterface {
    public function getID(): ?ID;
}
