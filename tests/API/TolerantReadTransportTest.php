<?php
/*
 * Created on   : Wed Oct 21 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : TolerantReadTransportTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\API;

use Lexoffice\API\Endpoints\Documents\{CreditNotesEndpoint, InvoicesEndpoint};
use Lexoffice\API\Endpoints\{EventSubscriptionsEndpoint, PaymentsEndpoint, VoucherListEndpoint, VouchersEndpoint};
use Lexoffice\Entities\EventSubscriptions\EventSubscription;
use Lexoffice\Entities\VoucherList\Voucher as VoucherListEntry;
use Lexoffice\Entities\Vouchers\VoucherID;
use Lexoffice\Enums\{ElectronicDocumentProfile, EventType, PaymentItemType, VoucherType};
use Tests\Contracts\TransportTestCase;

/**
 * Lesen mit Antworten aus der API-Referenz (https://developers.lexware.io/docs/),
 * ergänzt um Werte, die Lexware nachgereicht hat oder ankündigt.
 */
class TolerantReadTransportTest extends TransportTestCase {
    private const ID = 'a8691b5d-2393-4317-888d-bcd5d564f7d1';

    /**
     * Bis v1.3.2 erwartete `files` Datei-Objekte; jeder Beleg mit Datei warf.
     */
    public function test_voucher_files_are_a_list_of_ids(): void {
        $this->respondJson(200, [
            'id' => self::ID,
            'organizationId' => 'aa93e8a8-2aa3-470b-b914-caad8a255dd8',
            'type' => 'purchaseinvoice',
            'voucherStatus' => 'open',
            'voucherNumber' => '123-456',
            'voucherDate' => '2023-06-28T00:00:00.000+02:00',
            'totalGrossAmount' => 119.00,
            'totalTaxAmount' => 19.00,
            'taxType' => 'gross',
            'useCollectiveContact' => true,
            'voucherItems' => [['amount' => 119.00, 'taxAmount' => 19.00, 'taxRatePercent' => 19, 'categoryId' => '8f8664a8-fd86-11e1-a21f-0800200c9a66']],
            'files' => ['75295db7-7e69-4630-befd-a7f4ddfdaa83', '8118c402-1c70-4da1-a9f1-a22f480cc623'],
            'createdDate' => '2023-06-29T15:15:09.447+02:00',
            'updatedDate' => '2023-06-29T15:15:09.447+02:00',
            'version' => 1,
        ]);

        $voucher = (new VouchersEndpoint($this->client()))->get(new VoucherID(self::ID));

        $files = $voucher->getFiles();
        $this->assertNotNull($files);
        $this->assertCount(2, $files);
        $this->assertSame('75295db7-7e69-4630-befd-a7f4ddfdaa83', $files->getValues()[0]->toString());
        // Ein PUT ohne bestehende Datei-ID löscht die Datei: die Liste bleibt eine Liste von UUIDs.
        $this->assertSame(['75295db7-7e69-4630-befd-a7f4ddfdaa83', '8118c402-1c70-4da1-a9f1-a22f480cc623'], $voucher->toArray()['files']);
    }

    /**
     * Bis v1.3.2 ließ jede Art außerhalb der sieben Buchungsarten die ganze
     * Seite scheitern; `openAmount: null` ebenso.
     */
    public function test_voucher_list_reads_all_documented_and_unknown_types(): void {
        $row = static fn (string $type, ?float $openAmount): array => [
            'id' => self::ID, 'voucherType' => $type, 'voucherStatus' => 'open', 'voucherNumber' => 'X1',
            'voucherDate' => '2023-06-14T00:00:00.000+02:00', 'createdDate' => '2023-03-22T12:36:22.000+01:00',
            'updatedDate' => '2023-03-22T12:36:22.000+01:00', 'contactId' => null, 'contactName' => 'Sammelkunde',
            'totalAmount' => 80.04, 'openAmount' => $openAmount, 'currency' => 'EUR', 'archived' => false,
        ];
        $this->respondJson(200, [
            'content' => [
                $row('quotation', null),
                $row('orderconfirmation', null),
                $row('deliverynote', null),
                $row('downpaymentdeduction', 10.0),
                $row('voucher', 80.04),
                $row('invoice', 74.8),
                $row('einkuenftigertyp', 1.0),
            ],
            'first' => true, 'last' => true, 'totalPages' => 1, 'totalElements' => 7, 'numberOfElements' => 7, 'size' => 25, 'number' => 0,
        ]);

        $page = (new VoucherListEndpoint($this->client()))->search(['voucherType' => 'any', 'voucherStatus' => 'any']);

        $this->assertSame('https://api.lexware.io/v1/voucherlist?voucherType=any&voucherStatus=any', (string) $this->lastRequest()->getUri());
        /** @var list<VoucherListEntry> $entries */
        $entries = $page->getContent()->getValues();
        $this->assertCount(7, $entries);
        $this->assertSame(
            [VoucherType::QUOTATION, VoucherType::ORDERCONFIRMATION, VoucherType::DELIVERYNOTE, VoucherType::DOWNPAYMENTDEDUCTION, VoucherType::VOUCHER, VoucherType::INVOICE, null],
            array_map(static fn (VoucherListEntry $entry): ?VoucherType => $entry->getVoucherType(), $entries)
        );
        $this->assertSame('0.00', $entries[0]->getOpenAmount()->getAmount());
    }

    /**
     * Bis v1.3.2 fehlte `irrecoverableReceivable`; offene Zahlungen ohne
     * `paidDate` warfen beim Lesen des Datums.
     */
    public function test_payment_reads_irrecoverable_receivable_and_open_state(): void {
        $this->respondJson(200, [
            'openAmount' => 0.0, 'currency' => 'EUR', 'paymentStatus' => 'balanced', 'voucherType' => 'invoice', 'voucherStatus' => 'paid',
            'paidDate' => '2023-07-14T13:42:02.123+02:00',
            'paymentItems' => [
                ['paymentItemType' => 'manualPayment', 'postingDate' => '2023-07-14T00:00:00.000+01:00', 'amount' => 72.0, 'currency' => 'EUR'],
                ['paymentItemType' => 'irrecoverableReceivable', 'postingDate' => '2023-07-14T00:00:00.000+01:00', 'amount' => 7.85, 'currency' => 'EUR'],
                ['paymentItemType' => 'einkuenftigerposten', 'postingDate' => '2023-07-14T00:00:00.000+01:00', 'amount' => 1.0, 'currency' => 'EUR'],
            ],
        ]);
        $payment = (new PaymentsEndpoint($this->client()))->get(new VoucherID(self::ID));

        $items = $payment->getPaymentItems()->getValues();
        $this->assertSame(PaymentItemType::IRRECOVERABLERECEIVABLE, $items[1]->getPaymentItemType());
        $this->assertNull($items[2]->getPaymentItemType());

        $this->respondJson(200, ['openAmount' => 200.00, 'currency' => 'EUR', 'paymentStatus' => 'openRevenue', 'voucherType' => 'invoice', 'voucherStatus' => 'open', 'paymentItems' => []]);
        $open = (new PaymentsEndpoint($this->client()))->get(new VoucherID(self::ID));
        $this->assertNull($open->getPaidDate());
    }

    /**
     * Bis v1.3.2 fehlte `delivery-note.status.changed`; ein unbekannter Typ
     * ließ die ganze Abo-Liste scheitern.
     */
    public function test_event_subscriptions_read_all_documented_and_unknown_types(): void {
        $subscription = static fn (string $eventType): array => [
            'subscriptionId' => '49aa2f76-c51a-4df3-ae83-3a103d781494',
            'organizationId' => 'aa93e8a8-2aa3-470b-b914-caad8a255dd8',
            'createdDate' => '2023-04-11T12:20:00.000+02:00',
            'eventType' => $eventType,
            'callbackUrl' => 'https://example.org/webhook',
        ];
        $this->respondJson(200, ['content' => [
            $subscription('delivery-note.status.changed'),
            $subscription('contact.changed'),
            $subscription('einkuenftiges.ereignis'),
        ]]);

        $subscriptions = (new EventSubscriptionsEndpoint($this->client()))->list()->getValues();

        $this->assertSame(
            [EventType::DELIVERY_NOTE_STATUS_CHANGED, EventType::CONTACT_CHANGED, null],
            array_map(static fn (EventSubscription $entry): ?EventType => $entry->getEventType(), $subscriptions)
        );
    }

    /**
     * Rechnung laut Referenz: E-Rechnungsprofil (bis v1.3.2 verworfen) und
     * Kontaktperson als Zeichenkette (bis v1.3.2 als `{"contactId": …}` zurückgeschrieben).
     */
    public function test_invoice_reads_electronic_document_profile_and_contact_person(): void {
        $this->respondJson(200, [
            'id' => 'e9066f04-8cc7-4616-93f8-ac9ecc8479c8',
            'organizationId' => 'aa93e8a8-2aa3-470b-b914-caad8a255dd8',
            'createdDate' => '2023-04-24T08:20:22.528+02:00',
            'updatedDate' => '2023-04-24T08:20:22.528+02:00',
            'version' => 0,
            'language' => 'de',
            'archived' => false,
            'voucherStatus' => 'open',
            'voucherNumber' => 'RE1019',
            'voucherDate' => '2023-02-22T00:00:00.000+01:00',
            'dueDate' => '2023-03-22T00:00:00.000+01:00',
            'address' => ['contactId' => '97c5794f-8ab2-43ad-b459-c5980b055e4d', 'name' => 'Berliner Kindl GmbH', 'street' => 'Jubiläumsweg 25', 'city' => 'Berlin', 'zip' => '14089', 'countryCode' => 'DE', 'contactPerson' => 'Frau Erika Musterfrau'],
            'xRechnung' => ['buyerReference' => '04011000-1234512345-35'],
            'electronicDocumentProfile' => 'XRechnung',
            'lineItems' => [[
                'id' => '97b98491-e953-4dc9-97a9-ae437a8052b4', 'type' => 'material', 'name' => 'Abus Kabelschloss', 'quantity' => 2, 'unitName' => 'Stück',
                'unitPrice' => ['currency' => 'EUR', 'netAmount' => 13.4, 'grossAmount' => 15.95, 'taxRatePercentage' => 19],
                'discountPercentage' => 50, 'lineItemAmount' => 13.4,
            ]],
            'totalPrice' => ['currency' => 'EUR', 'totalNetAmount' => 13.4, 'totalGrossAmount' => 15.95, 'totalTaxAmount' => 2.55],
            'taxConditions' => ['taxType' => 'net'],
            'shippingConditions' => ['shippingDate' => '2023-04-22T00:00:00.000+02:00', 'shippingType' => 'delivery'],
            'closingInvoice' => false,
            'title' => 'Rechnung',
        ]);

        $invoice = (new InvoicesEndpoint($this->client()))->get(new VoucherID('e9066f04-8cc7-4616-93f8-ac9ecc8479c8'));

        $this->assertSame(ElectronicDocumentProfile::XRECHNUNG, $invoice->getElectronicDocumentProfile());
        $this->assertSame('Frau Erika Musterfrau', $invoice->getAddress()->getContactPerson());
        $this->assertSame('Frau Erika Musterfrau', $invoice->toArray()['address']['contactPerson']);
        $this->assertSame('XRechnung', $invoice->toArray()['electronicDocumentProfile']);
    }

    public function test_credit_note_reads_electronic_document_profile(): void {
        $this->respondJson(200, [
            'id' => 'e9066f04-8cc7-4616-93f8-ac9ecc8479c8',
            'voucherStatus' => 'draft',
            'voucherNumber' => 'GS0007',
            'voucherDate' => '2023-02-22T00:00:00.000+01:00',
            'address' => ['name' => 'Bike & Ride GmbH & Co. KG', 'city' => 'Freiburg', 'zip' => '79112', 'countryCode' => 'DE'],
            'electronicDocumentProfile' => 'NONE',
            'lineItems' => [['type' => 'custom', 'name' => 'Energieriegel Testpaket', 'quantity' => 1, 'unitName' => 'Stück', 'unitPrice' => ['currency' => 'EUR', 'netAmount' => 5, 'grossAmount' => 5, 'taxRatePercentage' => 0], 'lineItemAmount' => 5]],
            'totalPrice' => ['currency' => 'EUR', 'totalNetAmount' => 5, 'totalGrossAmount' => 5, 'totalTaxAmount' => 0],
            'taxConditions' => ['taxType' => 'net'],
        ]);

        $creditNote = (new CreditNotesEndpoint($this->client()))->get(new VoucherID('e9066f04-8cc7-4616-93f8-ac9ecc8479c8'));

        $this->assertSame(ElectronicDocumentProfile::NONE, $creditNote->getElectronicDocumentProfile());
    }
}
