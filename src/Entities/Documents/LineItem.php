<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\ID;
use Lexoffice\Enums\ItemType;
use Psr\Log\LoggerInterface;

class LineItem extends NamedEntity {
    protected ?ID $id;
    public ItemType $type;
    public string $name;
    public ?string $description;
    public float $quantity;
    public string $unitName;
    public ?UnitPrice $unitPrice;
    protected float $lineItemAmount;
    protected int $lineItemTemplateVersion;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
