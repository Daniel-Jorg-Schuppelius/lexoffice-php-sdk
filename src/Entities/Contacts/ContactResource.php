<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\API\ResourceAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

class ContactResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new Contact();
    }
}
