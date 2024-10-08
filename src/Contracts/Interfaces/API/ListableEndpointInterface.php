<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ListableEndpointInterface.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use APIToolkit\Contracts\Abstracts\NamedValues;
use APIToolkit\Contracts\Interfaces\API\EndpointInterfaces\ListableEndpointInterface as APIToolkitListableEndpointInterface;

interface ListableEndpointInterface extends APIToolkitListableEndpointInterface {
    public function list(array $options = []): NamedValues;
}
