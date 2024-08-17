<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\OrderConfirmations;

use Lexoffice\Contracts\Abstracts\ResourceAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

class OrderConfirmationResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new OrderConfirmation();
    }
}
