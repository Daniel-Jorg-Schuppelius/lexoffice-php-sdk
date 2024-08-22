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
    public ?float $quantity;
    public ?string $unitName;
    public ?UnitPrice $unitPrice;
    protected ?float $lineItemAmount;
    protected ?int $lineItemTemplateVersion;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function isValid(): bool {
        if (isset($this->type) && $this->type == ItemType::TEXT) {
            return isset($this->name);
        } elseif (isset($this->type) && $this->type == ItemType::CUSTOM) {
            return !isset($this->name)
                && !is_null($this->quantity)
                && !is_null($this->unitName)
                && (isset($this->unitPrice) && $this->unitPrice->isValid());
        }

        return !is_null($this->id)
            && isset($this->type)
            && isset($this->name)
            && !is_null($this->quantity)
            && !is_null($this->unitName)
            && (isset($this->unitPrice) && $this->unitPrice->isValid());
    }
}
