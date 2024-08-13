<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableInterface;
use Lexoffice\Enums\DistanceSalesPrinciple;
use Lexoffice\Enums\TaxType;
use Psr\Log\LoggerInterface;

class Profile extends NamedEntity implements OrganizationIdentifiableInterface {
    public OrganizationID $organizationId;
    public string $companyName;
    public Created $created;
    public ConnectionID $connectionId;
    public TaxType $taxType;
    public DistanceSalesPrinciple $distanceSalesPrinciple;
    public Features $features;
    public BusinessFeatures $businessFeatures;
    public bool $smallBusiness;
    public SubscriptionStatus $subscriptionStatus;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getOrganizationID(): OrganizationID {
        return $this->organizationId;
    }
}
