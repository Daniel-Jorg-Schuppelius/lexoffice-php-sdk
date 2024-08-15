<?php

declare(strict_types=1);

namespace Lexoffice\Entities\EventSubscriptions;

use Lexoffice\Contracts\Abstracts\API\ResourceAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

class EventSubscriptionResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new EventSubscription();
    }
}
