<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PostingCategories;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\PostingCategoryType;

class PostingCategory extends NamedEntity {
    public PostingCategoryID $id;
    public string $name;
    public PostingCategoryType $type;
    public bool $contactRequired;
    public bool $splitAllowed;
    public string $groupName;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
