<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Entities\ID;

class DocumentFileID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->name = 'documentFileId';
    }
}
