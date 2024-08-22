<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\TaxSubType;
use Lexoffice\Enums\TaxType;
use Psr\Log\LoggerInterface;

class TaxConditions extends NamedEntity {
    public TaxType $taxType;
    protected ?TaxSubType $taxSubType;
    protected ?string $taxTypeNote;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
