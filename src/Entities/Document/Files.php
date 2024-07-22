<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class Files extends NamedEntity {
    protected DocumentFileID $documentFileId;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
