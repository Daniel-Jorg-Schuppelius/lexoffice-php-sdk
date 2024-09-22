<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

use DateTime;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\IdentifiableNamedEntityInterface;

interface ResourceNamedEntityInterface extends IdentifiableNamedEntityInterface {
    public function getResourceUri(): string;
    public function getCreatedDate(): DateTime;
    public function getUpdatedDate(): DateTime;

    public function getResource(): NamedEntityInterface;
}