<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PrintLayouts;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Psr\Log\LoggerInterface;

class PrintLayout extends NamedEntity implements IdentifiableInterface {
    public PrintLayoutID $id;
    public string $name;
    public bool $default;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): PrintLayoutID {
        return $this->id;
    }
}
