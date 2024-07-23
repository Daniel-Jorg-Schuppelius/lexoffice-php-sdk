<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PostingCategories;

use Lexoffice\Entities\ID;

class PostingCategoryID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->entityName = 'id';
    }
}
