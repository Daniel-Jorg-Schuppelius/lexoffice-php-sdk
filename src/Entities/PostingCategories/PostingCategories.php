<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PostingCategories;

use Lexoffice\Contracts\Abstracts\NamedValues;

class PostingCategories extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = PostingCategory::class;
        parent::__construct($data);
    }
}
