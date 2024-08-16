<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Contracts\Interfaces\ResourceInterface;
use Lexoffice\Entities\ID;

interface ClassicEndpointInterface extends BaseEndpointInterface {
    public function create(NamedEntityInterface $data, ID $id = null): ResourceInterface;
    public function update(ID $id, NamedEntityInterface $data): ResourceInterface;
    public function delete(ID $id): bool;
}
