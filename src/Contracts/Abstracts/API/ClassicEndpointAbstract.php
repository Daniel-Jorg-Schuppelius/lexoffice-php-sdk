<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts\API;

use Lexoffice\Contracts\Interfaces\ResourceInterface;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\ID;

abstract class ClassicEndpointAbstract extends BaseEndpointAbstract {
    abstract public function create(NamedEntityInterface $data, ID $id = null): ResourceInterface;
    abstract public function get(?ID $id = null): NamedEntityInterface;
    abstract public function update(ID $id, NamedEntityInterface $data): ResourceInterface;
    abstract public function delete(ID $id): bool;
}
