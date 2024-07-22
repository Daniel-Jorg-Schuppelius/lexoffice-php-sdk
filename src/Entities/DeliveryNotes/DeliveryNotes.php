<?php

declare(strict_types=1);

namespace Lexoffice\Entities\DeliveryNotes;

use Lexoffice\Contracts\Abstracts\NamedDocument;

class DeliveryNotes extends NamedDocument {
    public function __construct($data = null) {
        parent::__construct($data);
    }
}
