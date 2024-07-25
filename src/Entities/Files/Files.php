<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class Files extends NamedValueList {
    public function __construct($data = null) {
        $this->className = File::class;
        parent::__construct($data);
    }
}
