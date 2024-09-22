<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use APIToolkit\Contracts\Abstracts\NamedValues;
use APIToolkit\Contracts\Interfaces\API\EndpointInterfaces\ListableEndpointInterface as APIToolkitListableEndpointInterface;

interface ListableEndpointInterface extends APIToolkitListableEndpointInterface {
    public function list(array $options = []): NamedValues;
}
