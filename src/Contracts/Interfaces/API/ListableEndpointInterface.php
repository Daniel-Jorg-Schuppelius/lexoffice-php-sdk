<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use APIToolkit\Contracts\Abstracts\NamedValues;

interface ListableEndpointInterface extends BaseEndpointInterface {
    public function list(array $options = []): NamedValues;
}
