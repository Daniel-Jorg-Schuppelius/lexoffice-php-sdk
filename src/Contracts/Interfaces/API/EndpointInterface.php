<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

interface EndpointInterface {
    public function create(array $data): ResourceInterface;
    public function get(string $id): NamedEntityInterface;
    public function update(string $id, array $data): NamedEntityInterface;
    public function delete(string $id): bool;
}
