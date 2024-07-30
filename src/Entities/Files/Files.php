<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use Lexoffice\Contracts\Abstracts\NamedValues;

class Files extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = File::class;
        parent::__construct($data);
    }
}
