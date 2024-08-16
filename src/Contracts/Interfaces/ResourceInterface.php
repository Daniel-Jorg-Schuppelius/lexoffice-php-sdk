<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

use DateTime;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

interface ResourceInterface extends IdentifiableInterface {
    public function getResourceUri(): string;
    public function getCreatedDate(): DateTime;
    public function getUpdatedDate(): DateTime;

    public function getResource(): NamedEntityInterface;
}
