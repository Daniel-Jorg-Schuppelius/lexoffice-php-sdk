<?php

declare(strict_types=1);

namespace Lexoffice\Entities\EventSubscriptions;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class EventSubscriptions extends NamedValueList {
    public function __construct($data = null) {
        $this->name = "content";
        $this->className = EventSubscription::class;

        if (!empty($data) && array_key_exists($this->name, $data)) {
            parent::__construct($data[$this->name]);
        } else {
            parent::__construct($data);
        }
    }
}
