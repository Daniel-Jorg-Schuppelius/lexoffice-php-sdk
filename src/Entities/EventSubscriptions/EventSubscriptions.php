<?php

declare(strict_types=1);

namespace Lexoffice\Entities\EventSubscriptions;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class EventSubscriptions extends NamedValueList {
    public function __construct($data = null) {
        $this->entityName = "content";
        $this->className = EventSubscription::class;

        if (!empty($data) && array_key_exists($this->entityName, $data)) {
            parent::__construct($data[$this->entityName]);
        } else {
            parent::__construct($data);
        }
    }
}
