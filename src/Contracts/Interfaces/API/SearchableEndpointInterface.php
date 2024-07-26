<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

interface SearchableEndpointInterface extends EndpointInterface {
    public function search(array $queryParams = []): NamedEntityInterface;
}
