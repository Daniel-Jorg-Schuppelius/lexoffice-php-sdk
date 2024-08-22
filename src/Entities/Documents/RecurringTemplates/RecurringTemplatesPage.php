<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\RecurringTemplates;

use Lexoffice\Contracts\Abstracts\NamedPage;
use Psr\Log\LoggerInterface;

class RecurringTemplatesPage extends NamedPage {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = RecurringTemplates::class;
        parent::__construct($data, $logger);
    }
}
