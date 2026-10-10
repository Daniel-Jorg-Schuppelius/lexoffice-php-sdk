<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : FileResource.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use Lexoffice\Contracts\Abstracts\ResourceAbstract;

class FileResource extends ResourceAbstract {
    /** Beleg, den Lexware zu einem `files`-Upload angelegt hat. */
    protected ?ID $voucherId = null;

    public function getResource(): NamedEntityInterface {
        return new File;
    }

    public function getVoucherId(): ?ID {
        return $this->voucherId;
    }
}
