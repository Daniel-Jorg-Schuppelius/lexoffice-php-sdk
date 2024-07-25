<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class File extends NamedEntity {
    protected FileID $id;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
