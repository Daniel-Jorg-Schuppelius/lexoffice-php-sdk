<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DeliveryNoteResource.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\DeliveryNotes;

use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Contracts\Abstracts\ResourceAbstract;

class DeliveryNoteResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new DeliveryNote;
    }
}
