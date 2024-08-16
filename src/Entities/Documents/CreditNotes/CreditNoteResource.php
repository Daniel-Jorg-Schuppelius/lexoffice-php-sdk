<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\CreditNotes;

use Lexoffice\Contracts\Abstracts\ResourceAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

class CreditNoteResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new CreditNote();
    }
}
