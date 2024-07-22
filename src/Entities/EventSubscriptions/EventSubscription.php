<?php

declare(strict_types=1);

namespace Lexoffice\Entities\EventSubscriptions;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\OrganizationID;
use Lexoffice\Enums\EventType;

class EventSubscription extends NamedEntity {
    protected SubscriptionID $subscriptionId;
    protected OrganizationID $organizationId;
    protected DateTime $createdDate;
    public EventType $eventType;
    public string $callbackUrl;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
