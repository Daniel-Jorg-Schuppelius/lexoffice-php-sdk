<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ProfileEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Entities\ID;
use Lexoffice\Entities\Profile\Profile;

class ProfileEndpoint extends EndpointAbstract {
    protected string $endpoint = 'profile';

    public function get(?ID $id = null): Profile {
        self::logDebug('Fetching profile');

        return self::logDebugWithTimer(
            fn () => Profile::fromJson(parent::getContents()),
            'Profile fetched'
        );
    }
}
