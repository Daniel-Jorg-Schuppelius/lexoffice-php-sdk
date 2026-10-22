<?php
/*
 * Created on   : Wed Oct 21 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : UuidID.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use APIToolkit\Entities\ID;
use CommonToolkit\Helper\Data\StringHelper;

/**
 * Basis aller Lexware-IDs: Lexware vergibt sie als UUID, die Prüfung von
 * {@see ID::isValid()} verlangt dagegen eine Zahl.
 *
 * Eine abgeleitete Klasse setzt ihren Entity-Namen vor `parent::__construct()`,
 * damit `fromArray(['contactId' => …])` den Schlüssel erkennt.
 */
abstract class UuidID extends ID {
    public function isValid(): bool {
        return is_string($this->value) && StringHelper::isUuid($this->value);
    }
}
