<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ClassicEndpointInterface.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use APIToolkit\Contracts\Interfaces\API\EndpointInterface;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use Lexoffice\Contracts\Interfaces\ResourceNamedEntityInterface;

interface ClassicEndpointInterface extends EndpointInterface {
    public function create(NamedEntityInterface $data, ID $id = null): ResourceNamedEntityInterface;
    public function update(ID $id, NamedEntityInterface $data): ResourceNamedEntityInterface;
    public function delete(ID $id): bool;
}
