<?php

declare(strict_types=1);

namespace Lexoffice\Entities\EventSubscriptions;

use Lexoffice\Contracts\Abstracts\NamedPage;
use Psr\Log\LoggerInterface;

class EventSubscriptionsPage extends NamedPage {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = EventSubscriptions::class;
        parent::__construct($data, $logger);
    }
}
