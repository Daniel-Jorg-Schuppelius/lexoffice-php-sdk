<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use Lexoffice\Contracts\Abstracts\NamedPage;
use Psr\Log\LoggerInterface;

class ArticlesPage extends NamedPage {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = Articles::class;
        parent::__construct($data, $logger);
    }
}
