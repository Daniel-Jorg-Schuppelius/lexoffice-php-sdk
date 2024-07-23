<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

interface NamedValueInterface extends NamedEntityInterface {
    public function isReadOnly(): bool;

    public function getData();
}
