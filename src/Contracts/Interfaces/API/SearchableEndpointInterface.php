<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use APIToolkit\Contracts\Interfaces\API\EndpointInterfaces\SearchableEndpointInterface as APIToolkitSearchableEndpointInterface;
use Lexoffice\Contracts\Abstracts\NamedPage;

interface SearchableEndpointInterface extends APIToolkitSearchableEndpointInterface {
    public function search(array $queryParams = [], array $options = []): NamedPage;
}
