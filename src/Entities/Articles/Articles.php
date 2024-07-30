<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use Lexoffice\Contracts\Abstracts\NamedValues;

class Articles extends NamedValues {
    public function __construct($data = null) {
        $this->entityName = "content";
        $this->valueClassName = Article::class;

        parent::__construct($data);
    }
}
