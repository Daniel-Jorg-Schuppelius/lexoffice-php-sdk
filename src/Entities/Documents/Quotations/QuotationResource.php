<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Quotations;

use Lexoffice\Contracts\Abstracts\ResourceAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

class QuotationResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new Quotation();
    }
}
