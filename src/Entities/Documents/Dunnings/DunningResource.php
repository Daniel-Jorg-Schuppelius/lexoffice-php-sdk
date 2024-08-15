<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Dunnings;

use Lexoffice\Contracts\Abstracts\API\ResourceAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

class DunningResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new Dunning();
    }
}
