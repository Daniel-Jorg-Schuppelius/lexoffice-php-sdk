<?php
/*
 * Created on   : Sun Jul 26 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : MoneyAccessorTrait.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Traits;

use CommonToolkit\Enums\CurrencyCode;
use CommonToolkit\ValueObjects\Money;

/**
 * Geldbeträge der Lexoffice-Entities.
 *
 * Die REST-API liefert Beträge als JSON-Zahlen; die Hydrierung legt sie
 * deshalb weiterhin als float ab (mehr Genauigkeit hat die Quelle nicht).
 * **Gelesen** wird ausschließlich {@see Money}: die Umwandlung passiert an
 * dieser einen Stelle, inklusive der Belegwährung — ab dort rechnet der
 * Aufrufer exakt.
 */
trait MoneyAccessorTrait {
    /**
     * Rohbetrag der API → Money in der Belegwährung (null bleibt null).
     */
    protected function toMoney(?float $amount, ?CurrencyCode $currency = null): ?Money {
        if ($amount === null) {
            return null;
        }

        return Money::ofFloat($amount, $currency ?? $this->entityCurrency());
    }

    /**
     * Belegwährung der Entity; ohne eigenes Feld gilt der Euro
     * (Lexoffice-Standard für deutsche Mandanten).
     */
    protected function entityCurrency(): CurrencyCode {
        if (property_exists($this, 'currency') && isset($this->currency) && $this->currency instanceof CurrencyCode) {
            return $this->currency;
        }

        return CurrencyCode::Euro;
    }
}
