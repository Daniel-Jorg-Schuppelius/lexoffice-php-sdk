<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\ID;

interface BaseEndpointInterface {
    public function get(?ID $id = null): NamedEntityInterface;
}
