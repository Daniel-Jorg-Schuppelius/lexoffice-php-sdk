<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\RecurringTemplates;

use Lexoffice\Contracts\Abstracts\ResourceAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

class RecurringTemplateResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new RecurringTemplate();
    }
}
