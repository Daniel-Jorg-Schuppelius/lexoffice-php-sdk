<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ProfileEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

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
