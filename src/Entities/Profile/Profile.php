<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\DistanceSalesPrinciple;
use Lexoffice\Enums\TaxType;

class Profile extends NamedEntity {
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

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
