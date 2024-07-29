<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;

class File extends NamedEntity implements IdentifiableInterface {
    protected FileID $id;

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getID(): FileID {
        return $this->id;
    }
}
