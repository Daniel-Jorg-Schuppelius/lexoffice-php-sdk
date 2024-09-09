<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use APIToolkit\Contracts\Abstracts\NamedValues;
use APIToolkit\Contracts\Interfaces\API\EndpointInterface;

interface ListableEndpointInterface extends EndpointInterface {
    public function list(array $options = []): NamedValues;
}
