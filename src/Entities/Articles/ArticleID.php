<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use APIToolkit\Entities\ID;
use Psr\Log\LoggerInterface;

class ArticleID extends ID {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
        $this->entityName = 'id';
    }
}
