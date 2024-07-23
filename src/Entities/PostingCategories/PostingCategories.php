<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PostingCategories;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class PostingCategories extends NamedValueList {
    public function __construct($data = null) {
        $this->className = PostingCategory::class;
        parent::__construct($data);
    }
}
