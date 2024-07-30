<?php

declare(strict_types=1);

namespace Lexoffice\Entities\EventSubscriptions;

use Lexoffice\Contracts\Abstracts\NamedValues;

class EventSubscriptions extends NamedValues {
    public function __construct($data = null) {
        $this->entityName = "content";
        $this->valueClassName = EventSubscription::class;

        parent::__construct($data);
    }
}
