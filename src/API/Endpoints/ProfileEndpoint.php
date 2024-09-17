<?php

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Entities\Profile\Profile;
use APIToolkit\Entities\ID;

class ProfileEndpoint extends EndpointAbstract {
    protected string $endpoint = 'profile';

    public function get(?ID $id = null): Profile {
        return Profile::fromJson(parent::getContents());
    }
}
