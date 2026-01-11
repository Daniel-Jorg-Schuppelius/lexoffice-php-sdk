<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : CountriesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\Countries\Countries;
use Lexoffice\Entities\Countries\Country;

class CountriesEndpoint extends EndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'countries';

    public function get(?ID $id = null): Country {
        self::logErrorAndThrow(NotAllowedException::class, 'Getting a single country is not allowed', [], null, 405);
    }

    public function list(array $options = []): Countries {
        self::logDebug('Listing countries');

        return self::logDebugWithTimer(
            fn() => Countries::fromJson(parent::getContents([], $options)),
            'Countries list fetched'
        );
    }
}
