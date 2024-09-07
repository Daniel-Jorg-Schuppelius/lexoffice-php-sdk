<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use Lexoffice\Contracts\Abstracts\ResourceAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;

class ArticleResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new Article();
    }
}
