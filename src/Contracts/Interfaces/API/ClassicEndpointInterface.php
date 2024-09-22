<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use APIToolkit\Contracts\Interfaces\API\EndpointInterface;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use Lexoffice\Contracts\Interfaces\ResourceNamedEntityInterface;

interface ClassicEndpointInterface extends EndpointInterface {
    public function create(NamedEntityInterface $data, ID $id = null): ResourceNamedEntityInterface;
    public function update(ID $id, NamedEntityInterface $data): ResourceNamedEntityInterface;
    public function delete(ID $id): bool;
}
