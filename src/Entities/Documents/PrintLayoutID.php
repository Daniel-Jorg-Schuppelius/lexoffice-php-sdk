<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Psr\Log\LoggerInterface;

class PrintLayoutID extends \Lexoffice\Entities\PrintLayouts\PrintLayoutID {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
        $this->entityName = 'printLayoutId';
    }
}
