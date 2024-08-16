<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use Lexoffice\Contracts\Abstracts\ResourceAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

class FileResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new File();
    }
}
