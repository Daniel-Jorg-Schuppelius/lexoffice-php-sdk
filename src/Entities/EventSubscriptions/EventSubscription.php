<?php

declare(strict_types=1);

namespace Lexoffice\Entities\EventSubscriptions;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableInterface;
use Lexoffice\Contracts\Interfaces\TimestampableInterface;
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Enums\EventType;
use Psr\Log\LoggerInterface;

class EventSubscription extends NamedEntity implements IdentifiableInterface, OrganizationIdentifiableInterface, TimestampableInterface {
    protected ?SubscriptionID $subscriptionId;
    protected ?OrganizationID $organizationId;
    protected ?DateTime $createdDate;
    public EventType $eventType;
    public string $callbackUrl;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): SubscriptionID {
        return $this->subscriptionId;
    }

    public function getOrganizationID(): OrganizationID {
        return $this->organizationId;
    }

    public function getCreatedDate(): ?DateTime {
        return $this->createdDate;
    }
}
