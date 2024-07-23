<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\Documents\DocumentFileID;

class Files extends NamedEntity {
    protected DocumentFileID $id;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
