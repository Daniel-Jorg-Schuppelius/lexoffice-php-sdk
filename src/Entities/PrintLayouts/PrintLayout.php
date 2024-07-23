<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PrintLayouts;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class PrintLayout extends NamedEntity {
    public PrintLayoutID $id;
    public string $name;
    public bool $default;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
