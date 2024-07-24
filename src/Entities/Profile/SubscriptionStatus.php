<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use Lexoffice\Contracts\Abstracts\NamedValue;

class SubscriptionStatus extends NamedValue {
    public function __construct($data = null) {
        parent::__construct($data);
    }
}
