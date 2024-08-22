<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\Countries\Countries;
use Lexoffice\Entities\Countries\Country;
use Lexoffice\Entities\ID;
use Lexoffice\Exceptions\NotAllowedException;

class CountriesEndpoint extends BaseEndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'countries';

    public function get(?ID $id = null): Country {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function list(array $options = []): Countries {
        return Countries::fromJson(parent::getContents([], $options));
    }
}
