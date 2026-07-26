<?php
/*
 * Created on   : Sun Jul 26 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : UnitPriceTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Entities\Documents;

use CommonToolkit\Enums\CurrencyCode;
use Lexoffice\Entities\Documents\UnitPrice;
use PHPUnit\Framework\TestCase;

class UnitPriceTest extends TestCase {
    public function test_derives_net_from_gross(): void {
        $price = new UnitPrice([
            'currency' => 'EUR',
            'grossAmount' => 11.90,
            'taxRatePercentage' => 19.0,
        ]);

        $this->assertSame('10.00', $price->getNetAmount()?->getAmount());
        $this->assertSame('11.90', $price->getGrossAmount()?->getAmount());
    }

    public function test_derives_gross_from_net(): void {
        $price = new UnitPrice([
            'currency' => 'EUR',
            'netAmount' => 10.00,
            'taxRatePercentage' => 19.0,
        ]);

        $this->assertSame('11.90', $price->getGrossAmount()?->getAmount());
        $this->assertSame('10.00', $price->getNetAmount()?->getAmount());
    }

    /**
     * Regression: Ohne Default für taxRatePercentage warf der Konstruktor
     * "Typed property must not be accessed before initialization", sobald die
     * API einen Betrag ohne Steuersatz lieferte.
     */
    public function test_amount_without_tax_rate_does_not_throw(): void {
        $net = new UnitPrice(['currency' => 'EUR', 'netAmount' => 10.00]);
        $this->assertSame('10.00', $net->getNetAmount()?->getAmount());
        $this->assertSame('10.00', $net->getGrossAmount()?->getAmount());

        $gross = new UnitPrice(['currency' => 'EUR', 'grossAmount' => 10.00]);
        $this->assertSame('10.00', $gross->getNetAmount()?->getAmount());
        $this->assertSame('10.00', $gross->getGrossAmount()?->getAmount());
    }

    /**
     * Regression: getCurrency() griff auf eine uninitialisierte Property zu,
     * wenn die Antwort kein Währungsfeld enthielt.
     */
    public function test_currency_falls_back_to_euro(): void {
        $price = new UnitPrice(['netAmount' => 10.00, 'taxRatePercentage' => 19.0]);

        $this->assertSame(CurrencyCode::Euro, $price->getCurrency());
        $this->assertSame('11.90', $price->getGrossAmount()?->getAmount());
    }

    public function test_empty_price_is_zero(): void {
        $price = new UnitPrice([]);

        $this->assertSame('0.00', $price->getNetAmount()?->getAmount());
        $this->assertSame('0.00', $price->getGrossAmount()?->getAmount());
        $this->assertSame(CurrencyCode::Euro, $price->getCurrency());
    }

    /**
     * Netto → brutto → netto muss auf den Ausgangswert zurückführen; die
     * Ableitung läuft über Money und rundet damit wie das Lesen.
     */
    public function test_round_trip_stays_stable(): void {
        foreach ([19.0, 7.0, 0.0] as $rate) {
            foreach ([0.01, 9.99, 10.00, 123.45, 9999.99] as $net) {
                $gross = (new UnitPrice([
                    'currency' => 'EUR',
                    'netAmount' => $net,
                    'taxRatePercentage' => $rate,
                ]))->getGrossAmount()?->toFloat();

                $back = new UnitPrice([
                    'currency' => 'EUR',
                    'grossAmount' => $gross,
                    'taxRatePercentage' => $rate,
                ]);

                $this->assertEqualsWithDelta(
                    $net,
                    $back->getNetAmount()?->toFloat(),
                    0.01,
                    "netto $net bei $rate %"
                );
            }
        }
    }
}
