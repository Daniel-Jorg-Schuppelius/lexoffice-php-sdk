<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

interface NamedEntityInterface {
    public function __construct($data = null);

    public function getName(): string;
    public function setData($data): self;
}
