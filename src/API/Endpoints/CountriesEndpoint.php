<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : CountriesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\Countries\Countries;
use Lexoffice\Entities\Countries\Country;
use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;

class CountriesEndpoint extends EndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'countries';

    public function get(?ID $id = null): Country {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function list(array $options = []): Countries {
        return Countries::fromJson(parent::getContents([], $options));
    }
}
