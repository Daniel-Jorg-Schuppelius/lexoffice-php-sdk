<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use DateTime;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\ID;

interface ResourceInterface {
    public function getId(): ID;

    public function getResourceUri(): string;
    public function getCreatedDate(): DateTime;
    public function getUpdatedDate(): DateTime;

    public function getResource(): NamedEntityInterface;
}
