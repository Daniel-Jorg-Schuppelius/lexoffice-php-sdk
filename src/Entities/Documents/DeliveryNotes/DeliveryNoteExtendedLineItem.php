<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\DeliveryNotes;

use Lexoffice\Entities\Documents\ExtendedLineItem;
use Lexoffice\Enums\ItemType;

class DeliveryNoteExtendedLineItem extends ExtendedLineItem {
    public function isValid(): bool {
        if (isset($this->type) && $this->type == ItemType::TEXT) {
            return isset($this->name);
        } elseif (isset($this->type) && $this->type == ItemType::CUSTOM) {
            return isset($this->name)
                && (isset($this->quantity) && !is_null($this->quantity))
                && (isset($this->unitName) && !is_null($this->unitName));
        }

        return !is_null($this->id)
            && isset($this->type)
            && isset($this->name)
            && (isset($this->quantity) && !is_null($this->quantity))
            && (isset($this->unitName) && !is_null($this->unitName));
    }
}
