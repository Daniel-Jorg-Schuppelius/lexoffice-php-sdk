<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableNamedEntityInterface;
use Lexoffice\Enums\DistanceSalesPrinciple;
use Lexoffice\Enums\TaxType;
use Psr\Log\LoggerInterface;

class Profile extends NamedEntity implements OrganizationIdentifiableNamedEntityInterface {
    protected OrganizationID $organizationId;
    protected string $companyName;
    protected Created $created;
    protected ConnectionID $connectionId;
    protected TaxType $taxType;
    protected DistanceSalesPrinciple $distanceSalesPrinciple;
    protected Features $features;
    protected BusinessFeatures $businessFeatures;
    protected bool $smallBusiness;
    protected SubscriptionStatus $subscriptionStatus;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getOrganizationID(): OrganizationID {
        return $this->organizationId;
    }

    public function getCompanyName(): string {
        return $this->companyName;
    }

    public function getCreated(): Created {
        return $this->created;
    }

    public function getConnectionID(): ConnectionID {
        return $this->connectionId;
    }

    public function getTaxType(): TaxType {
        return $this->taxType;
    }

    public function getDistanceSalesPrinciple(): DistanceSalesPrinciple {
        return $this->distanceSalesPrinciple;
    }

    public function getFeatures(): Features {
        return $this->features;
    }

    public function getBusinessFeatures(): BusinessFeatures {
        return $this->businessFeatures;
    }

    public function getSubscriptionStatus(): SubscriptionStatus {
        return $this->subscriptionStatus;
    }

    public function isSmallBusiness(): bool {
        return $this->smallBusiness;
    }
}
