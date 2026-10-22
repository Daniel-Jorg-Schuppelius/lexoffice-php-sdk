<?php
/*
 * Created on   : Wed Oct 21 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DocumentCreateTransportTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\API;

use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\API\Endpoints\ArticlesEndpoint;
use Lexoffice\API\Endpoints\Documents\{CreditNotesEndpoint, DeliveryNotesEndpoint, InvoicesEndpoint, OrderConfirmationsEndpoint, QuotationsEndpoint};
use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Entities\Articles\Article;
use Lexoffice\Entities\Documents\CreditNotes\CreditNote;
use Lexoffice\Entities\Documents\DeliveryNotes\DeliveryNote;
use Lexoffice\Entities\Documents\Invoices\Invoice;
use Lexoffice\Entities\Documents\OrderConfirmations\OrderConfirmation;
use Lexoffice\Entities\Documents\Quotations\Quotation;
use Lexoffice\Entities\Vouchers\VoucherID;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Contracts\TransportTestCase;

/**
 * Anlegen von Verkaufsbelegen: was das SDK tatsächlich an Lexware sendet.
 */
class DocumentCreateTransportTest extends TransportTestCase {
    private const CONTACT_ID = '0b4c8b2b-1c3d-4e5f-8a9b-0c1d2e3f4a5b';
    private const QUOTATION_ID = '8f8664a8-fd86-11e1-a21f-0800200c9a66';

    /**
     * @return array<string, mixed>
     */
    private static function payload(bool $withShipping = true): array {
        $payload = [
            'voucherDate' => '2026-10-21T00:00:00.000+01:00',
            'address' => ['contactId' => self::CONTACT_ID],
            'lineItems' => [[
                'type' => 'custom',
                'name' => 'Montage',
                'quantity' => 1.5,
                'unitName' => 'Stunde',
                'unitPrice' => ['currency' => 'EUR', 'netAmount' => 80.0, 'taxRatePercentage' => 19.0],
            ]],
            'totalPrice' => ['currency' => 'EUR'],
            'taxConditions' => ['taxType' => 'net'],
        ];
        if ($withShipping) {
            $payload['shippingConditions'] = ['shippingDate' => '2026-10-21T00:00:00.000+01:00', 'shippingType' => 'service'];
        }

        return $payload;
    }

    /**
     * @return array<string, array{class-string<DocumentEndpointAbstract>, class-string<NamedEntityInterface>, string, bool}>
     */
    public static function documentsWithContact(): array {
        return [
            'Rechnung' => [InvoicesEndpoint::class, Invoice::class, 'invoices', true],
            'Gutschrift' => [CreditNotesEndpoint::class, CreditNote::class, 'credit-notes', false],
            'Angebot' => [QuotationsEndpoint::class, Quotation::class, 'quotations', false],
            'Auftragsbestätigung' => [OrderConfirmationsEndpoint::class, OrderConfirmation::class, 'order-confirmations', true],
        ];
    }

    /**
     * Bis v1.3.2 verlangte die Kontakt-ID eine Zahl; jede UUID machte den
     * Beleg ungültig („data is not valid“), bevor eine Anfrage hinausging.
     *
     * @param class-string<DocumentEndpointAbstract> $endpointClass
     * @param class-string<NamedEntityInterface> $entityClass
     */
    #[DataProvider('documentsWithContact')]
    public function test_document_addressed_by_contact_id_is_sent(string $endpointClass, string $entityClass, string $path, bool $withShipping): void {
        $this->respondCreated();

        $document = $entityClass::fromArray(self::payload($withShipping));
        $this->assertTrue($document->isValid());

        (new $endpointClass($this->client()))->create($document);

        $this->assertSame("https://api.lexware.io/v1/{$path}", (string) $this->lastRequest()->getUri());
        // Ohne Angabe kein Land: DE überschriebe das Land eines Auslandskontakts.
        $this->assertSame(['contactId' => self::CONTACT_ID], $this->lastJsonBody()['address']);
    }

    public function test_given_country_code_is_sent_unchanged(): void {
        $this->respondCreated();
        $payload = self::payload();
        $payload['address'] = ['contactId' => self::CONTACT_ID, 'name' => 'Wiener Werkstatt', 'city' => 'Wien', 'zip' => '1010', 'countryCode' => 'AT'];

        (new InvoicesEndpoint($this->client()))->create(Invoice::fromArray($payload));

        $this->assertSame('AT', $this->lastJsonBody()['address']['countryCode']);
    }

    /**
     * Lexware liest je nach taxType genau einen Betrag; bis v1.3.2 ergänzte das
     * SDK den jeweils anderen (bei fehlendem Satz mit 0 %).
     */
    public function test_unit_price_is_sent_as_given(): void {
        $this->respondCreated();
        (new InvoicesEndpoint($this->client()))->create(Invoice::fromArray(self::payload()));
        // Guzzle kodiert 80.0 als 80, daher assertEquals.
        $this->assertEquals(
            ['currency' => 'EUR', 'netAmount' => 80.0, 'taxRatePercentage' => 19.0],
            $this->lastJsonBody()['lineItems'][0]['unitPrice']
        );

        $this->respondCreated();
        $gross = self::payload();
        $gross['taxConditions'] = ['taxType' => 'gross'];
        $gross['lineItems'][0]['unitPrice'] = ['currency' => 'EUR', 'grossAmount' => 95.2, 'taxRatePercentage' => 19.0];
        (new InvoicesEndpoint($this->client()))->create(Invoice::fromArray($gross));
        $this->assertEquals(
            ['currency' => 'EUR', 'grossAmount' => 95.2, 'taxRatePercentage' => 19.0],
            $this->lastJsonBody()['lineItems'][0]['unitPrice']
        );
    }

    /**
     * Bis v1.3.2 setzte der Lieferschein fehlende Versandbedingungen auf
     * „service, jetzt“ — beim Anlegen wie beim Zurücklesen.
     */
    public function test_delivery_note_sends_no_invented_shipping_conditions(): void {
        $this->respondCreated();
        $payload = self::payload(false);
        unset($payload['totalPrice'], $payload['lineItems'][0]['unitPrice']);
        $payload['deliveryTerms'] = 'Lieferung frei Haus.';

        (new DeliveryNotesEndpoint($this->client()))->create(DeliveryNote::fromArray($payload));

        $body = $this->lastJsonBody();
        $this->assertArrayNotHasKey('shippingConditions', $body);
        $this->assertArrayNotHasKey('unitPrice', $body['lineItems'][0]);
        $this->assertSame('Lieferung frei Haus.', $body['deliveryTerms']);

        $this->respondCreated();
        $payload['shippingConditions'] = ['shippingDate' => '2026-10-20T00:00:00.000+02:00', 'shippingType' => 'delivery'];
        (new DeliveryNotesEndpoint($this->client()))->create(DeliveryNote::fromArray($payload));
        $this->assertSame($payload['shippingConditions'], $this->lastJsonBody()['shippingConditions']);
    }

    /**
     * @return array<string, array{class-string<DocumentEndpointAbstract>, class-string<NamedEntityInterface>, string, bool}>
     */
    public static function pursuableDocuments(): array {
        return [
            'Rechnung' => [InvoicesEndpoint::class, Invoice::class, 'invoices', true],
            'Gutschrift' => [CreditNotesEndpoint::class, CreditNote::class, 'credit-notes', false],
            'Auftragsbestätigung' => [OrderConfirmationsEndpoint::class, OrderConfirmation::class, 'order-confirmations', true],
            'Lieferschein' => [DeliveryNotesEndpoint::class, DeliveryNote::class, 'delivery-notes', true],
        ];
    }

    /**
     * Bis v1.3.2 verwarf create() den Vorgänger.
     *
     * @param class-string<DocumentEndpointAbstract> $endpointClass
     * @param class-string<NamedEntityInterface> $entityClass
     */
    #[DataProvider('pursuableDocuments')]
    public function test_create_passes_the_preceding_voucher(string $endpointClass, string $entityClass, string $path, bool $withShipping): void {
        $this->respondCreated();

        (new $endpointClass($this->client()))->create($entityClass::fromArray(self::payload($withShipping)), new VoucherID(self::QUOTATION_ID), true);

        $this->assertSame(
            "https://api.lexware.io/v1/{$path}?precedingSalesVoucherId=" . self::QUOTATION_ID . '&finalize=true',
            (string) $this->lastRequest()->getUri()
        );
        $this->assertSame(self::CONTACT_ID, $this->lastJsonBody()['address']['contactId']);
    }

    /**
     * Bis v1.3.2 sendete pursue() immer `{}`; Lexware erwartet den Beleg.
     */
    public function test_pursue_sends_the_document(): void {
        $this->respondCreated();
        $invoice = Invoice::fromArray(self::payload());

        (new InvoicesEndpoint($this->client()))->pursue(new VoucherID(self::QUOTATION_ID), false, $invoice);

        $this->assertSame(
            'https://api.lexware.io/v1/invoices?precedingSalesVoucherId=' . self::QUOTATION_ID,
            (string) $this->lastRequest()->getUri()
        );
        $this->assertEquals($invoice->toArray(), $this->lastJsonBody());
    }

    /**
     * Bis v1.3.2 ging ein fehlender Steuersatz als `"taxRate": 0` hinaus.
     */
    public function test_article_price_without_tax_rate_is_not_sent_as_zero(): void {
        $this->respondJson(201, ['id' => 'f5d5e4c2-e20a-11ee-9cde-7789c0d1fa1c', 'resourceUri' => 'u', 'createdDate' => '2024-03-14T14:58:10.320+01:00', 'updatedDate' => '2024-03-14T14:58:10.320+01:00', 'version' => 0]);
        $article = Article::fromArray(['title' => 'Montage', 'type' => 'SERVICE', 'unitName' => 'Stunde', 'price' => ['netPrice' => 61.9, 'leadingPrice' => 'NET']]);

        $this->assertFalse($article->getPrice()->isValid());
        $this->assertNull($article->getPrice()->getTaxRate());

        (new ArticlesEndpoint($this->client()))->create($article);
        $this->assertArrayNotHasKey('taxRate', $this->lastJsonBody()['price']);
    }
}
