<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;

interface OrganizationIdentifiableNamedEntityInterface extends NamedEntityInterface {
    public function getOrganizationID(): ?ID;
}
