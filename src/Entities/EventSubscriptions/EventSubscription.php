<?php

declare(strict_types=1);

namespace Lexoffice\Entities\EventSubscriptions;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableInterface;
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Enums\EventType;

class EventSubscription extends NamedEntity implements IdentifiableInterface, OrganizationIdentifiableInterface {
    protected SubscriptionID $subscriptionId;
    protected OrganizationID $organizationId;
    protected DateTime $createdDate;
    public EventType $eventType;
    public string $callbackUrl;

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getID(): SubscriptionID {
        return $this->subscriptionId;
    }

    public function getOrganizationID(): OrganizationID {
        return $this->organizationId;
    }
}
