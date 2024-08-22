<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Entities\Profile\Profile;
use Lexoffice\Entities\ID;

class ProfileEndpoint extends BaseEndpointAbstract {
    protected string $endpoint = 'profile';

    public function get(?ID $id = null): Profile {
        return Profile::fromJson(parent::getContents());
    }
}
