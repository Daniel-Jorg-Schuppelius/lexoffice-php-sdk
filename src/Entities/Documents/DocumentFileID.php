<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Entities\Files\FileID;

class DocumentFileID extends FileID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->entityName = 'documentFileId';
    }
}
