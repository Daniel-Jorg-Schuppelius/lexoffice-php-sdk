<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\DeliveryNotes;

use Lexoffice\Contracts\Abstracts\ResourceAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;

class DeliveryNoteResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new DeliveryNote();
    }
}
