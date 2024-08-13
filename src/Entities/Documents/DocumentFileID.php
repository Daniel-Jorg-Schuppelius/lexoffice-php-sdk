<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Entities\Files\FileID;
use Psr\Log\LoggerInterface;

class DocumentFileID extends FileID {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
        $this->entityName = 'documentFileId';
    }
}
