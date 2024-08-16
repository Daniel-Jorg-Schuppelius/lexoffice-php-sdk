<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use Lexoffice\Contracts\Abstracts\NamedValues;

interface ListableEndpointInterface extends ClassicEndpointInterface {
    public function list(array $queryParams = []): NamedValues;
}
