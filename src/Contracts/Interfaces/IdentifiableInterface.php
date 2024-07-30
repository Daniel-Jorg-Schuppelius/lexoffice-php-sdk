<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

use Lexoffice\Entities\ID;

interface IdentifiableInterface {
    public function getID(): ID;
}