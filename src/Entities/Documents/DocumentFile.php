<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class DocumentFile extends NamedEntity {
    protected DocumentFileID $documentFileId;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}