<?php

declare(strict_types=1);

namespace Lexoffice\Entities\EventSubscriptions;

use Lexoffice\Entities\ID;
use Psr\Log\LoggerInterface;

class SubscriptionID extends ID {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
        $this->entityName = 'subscriptionId';
    }
}
