<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use Lexoffice\Contracts\Abstracts\NamedPage;

interface SearchableEndpointInterface extends ClassicEndpointInterface {
    public function search(array $queryParams = []): NamedPage;
}
