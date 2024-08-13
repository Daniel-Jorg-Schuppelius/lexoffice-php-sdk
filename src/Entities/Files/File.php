<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Psr\Log\LoggerInterface;

class File extends NamedEntity implements IdentifiableInterface {
    protected FileID $id;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): FileID {
        return $this->id;
    }
}
