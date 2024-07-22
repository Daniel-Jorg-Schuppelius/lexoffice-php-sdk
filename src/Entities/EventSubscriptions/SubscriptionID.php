<?php

declare(strict_types=1);

namespace Lexoffice\Entities\EventSubscriptions;

use Lexoffice\Entities\ID;

class SubscriptionID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->name = 'subscriptionId';
    }
}
