<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : SearchableEndpointInterface.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use APIToolkit\Contracts\Interfaces\API\EndpointInterfaces\SearchableEndpointInterface as APIToolkitSearchableEndpointInterface;
use Lexoffice\Contracts\Abstracts\NamedPage;

interface SearchableEndpointInterface extends APIToolkitSearchableEndpointInterface {
    public function search(array $queryParams = [], array $options = []): NamedPage;
}
