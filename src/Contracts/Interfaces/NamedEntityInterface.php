<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

use Psr\Log\LoggerInterface;

interface NamedEntityInterface {
    public function __construct($data = null, ?LoggerInterface $logger = null);

    public function getEntityName(): string;
    public function setData($data): self;

    public function isValid(): bool;

    public function toArray(): array;
    public function toJson(): string;

    public static function fromArray(array $data): self;
    public static function fromJson(string $data): self;
}
