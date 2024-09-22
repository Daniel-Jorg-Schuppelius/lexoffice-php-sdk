<?php

declare(strict_types=1);

namespace Lexoffice\Entities\EventSubscriptions;

use DateTime;
use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\IdentifiableNamedEntityInterface;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\TimestampableNamedEntityInterface;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableNamedEntityInterface;
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Enums\EventType;
use Psr\Log\LoggerInterface;

class EventSubscription extends NamedEntity implements IdentifiableNamedEntityInterface, OrganizationIdentifiableNamedEntityInterface, TimestampableNamedEntityInterface {
    protected ?SubscriptionID $subscriptionId;
    protected ?OrganizationID $organizationId;
    protected ?DateTime $createdDate;
    protected EventType $eventType;
    protected string $callbackUrl;

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

    public function getEventType(): EventType {
        return $this->eventType;
    }

    public function getCallbackUrl(): string {
        return $this->callbackUrl;
    }

    public function setEventType(EventType $eventType): void {
        $this->eventType = $eventType;
    }

    public function setCallbackUrl(string $callbackUrl): void {
        $this->callbackUrl = $callbackUrl;
    }
}
