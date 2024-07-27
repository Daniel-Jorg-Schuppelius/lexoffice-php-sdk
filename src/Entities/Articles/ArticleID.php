<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use Lexoffice\Entities\ID;

class ArticleID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->entityName = 'id';
    }
}
