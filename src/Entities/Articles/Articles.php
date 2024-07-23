<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class Articles extends NamedValueList {
    public function __construct($data = null) {
        $this->entityName = "content";
        $this->className = Article::class;

        parent::__construct($data);
    }
}
