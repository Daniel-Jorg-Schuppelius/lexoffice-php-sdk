<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

interface NamedEntityInterface {
    public function __construct($data = null);

    public function getEntityName(): string;
    public function setData($data): self;

    public function toArray(): array;
    public function toJson(): string;

    public static function fromArray(array $data): self;
    public static function fromJson(string $data): self;
}
