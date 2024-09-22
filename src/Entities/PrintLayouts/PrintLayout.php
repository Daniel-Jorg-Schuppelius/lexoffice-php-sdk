<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PrintLayouts;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\IdentifiableNamedEntityInterface;
use Psr\Log\LoggerInterface;

class PrintLayout extends NamedEntity implements IdentifiableNamedEntityInterface {
    protected PrintLayoutID $id;
    protected string $name;
    protected bool $default;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): PrintLayoutID {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function isDefault(): bool {
        return $this->default;
    }
}
