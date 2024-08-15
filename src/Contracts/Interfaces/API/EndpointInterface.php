<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\ID;

interface EndpointInterface {
    public function create(NamedEntityInterface $data, ID $id = null): ResourceInterface;
    public function get(ID $id): NamedEntityInterface;
    public function update(ID $id, NamedEntityInterface $data): ResourceInterface;
    public function delete(ID $id): bool;
}
