<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PrintLayouts;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;

class PrintLayout extends NamedEntity implements IdentifiableInterface {
    public PrintLayoutID $id;
    public string $name;
    public bool $default;

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getID(): PrintLayoutID {
        return $this->id;
    }
}
