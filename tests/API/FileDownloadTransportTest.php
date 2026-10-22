<?php
/*
 * Created on   : Wed Oct 21 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : FileDownloadTransportTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\API;

use GuzzleHttp\Psr7\Response;
use Lexoffice\API\Endpoints\Documents\{CreditNotesEndpoint, DeliveryNotesEndpoint, DownPaymentInvoicesEndpoint, DunningsEndpoint, InvoicesEndpoint, OrderConfirmationsEndpoint, QuotationsEndpoint};
use Lexoffice\API\Endpoints\FilesEndpoint;
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\Files\FileID;
use Lexoffice\Entities\Vouchers\VoucherID;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Contracts\TransportTestCase;

/**
 * Dateiabruf: Bytes, Medientyp und Dateiname im Speicher, mit passendem
 * Accept-Header.
 */
class FileDownloadTransportTest extends TransportTestCase {
    private const FILE_ID = '75295db7-7e69-4630-befd-a7f4ddfdaa83';
    private const VOUCHER_ID = 'e9066f04-8cc7-4616-93f8-ac9ecc8479c8';

    /**
     * Bis v1.3.2 schrieb der Endpunkt nur auf die Platte, sendete den
     * Client-Standard `Accept: application/json` und nannte den Typ nicht.
     */
    public function test_file_content_is_returned_with_its_media_type(): void {
        $this->handler->append(new Response(200, [
            'Content-Type' => 'application/xml;charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="RE-4711.xml"',
        ], '<?xml version="1.0"?><Invoice/>'));

        $file = (new FilesEndpoint($this->client()))->downloadContent(new FileID(self::FILE_ID), 'application/xml');

        $request = $this->lastRequest();
        $this->assertSame('https://api.lexware.io/v1/files/' . self::FILE_ID, (string) $request->getUri());
        $this->assertSame('application/xml', $request->getHeaderLine('Accept'));
        $this->assertSame('<?xml version="1.0"?><Invoice/>', $file->getContent());
        $this->assertSame('application/xml', $file->getMimeType());
        $this->assertSame('application/xml;charset=UTF-8', $file->getContentType());
        $this->assertSame('RE-4711.xml', $file->getFileName());
        $this->assertSame(31, $file->getSize());
    }

    public function test_default_accept_is_any_media_type(): void {
        $this->handler->append(new Response(200, ['Content-Type' => 'application/pdf'], '%PDF-1.4'));

        $file = (new FilesEndpoint($this->client()))->downloadContent(new FileID(self::FILE_ID));

        $this->assertSame('*/*', $this->lastRequest()->getHeaderLine('Accept'));
        $this->assertSame('application/pdf', $file->getMimeType());
        $this->assertNull($file->getFileName());
    }

    public function test_download_to_directory_sends_any_media_type(): void {
        $this->handler->append(new Response(200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="beleg.pdf"'], '%PDF-1.4'));
        $dir = sys_get_temp_dir() . '/lexoffice-download-' . uniqid();
        mkdir($dir);

        try {
            $file = (new FilesEndpoint($this->client()))->download(new FileID(self::FILE_ID), $dir);

            $this->assertSame('*/*', $this->lastRequest()->getHeaderLine('Accept'));
            $this->assertSame($dir . '/beleg.pdf', $file->getFilePath());
            $this->assertSame('%PDF-1.4', file_get_contents($dir . '/beleg.pdf'));
        } finally {
            @unlink($dir . '/beleg.pdf');
            @rmdir($dir);
        }
    }

    /**
     * @return array<string, array{class-string, string}>
     */
    public static function documentEndpoints(): array {
        return [
            'Rechnung' => [InvoicesEndpoint::class, 'invoices'],
            'Gutschrift' => [CreditNotesEndpoint::class, 'credit-notes'],
            'Lieferschein' => [DeliveryNotesEndpoint::class, 'delivery-notes'],
            'Mahnung' => [DunningsEndpoint::class, 'dunnings'],
            'Auftragsbestätigung' => [OrderConfirmationsEndpoint::class, 'order-confirmations'],
            'Angebot' => [QuotationsEndpoint::class, 'quotations'],
            'Abschlagsrechnung' => [DownPaymentInvoicesEndpoint::class, 'down-payment-invoices'],
        ];
    }

    /**
     * `GET /{beleg}/{id}/file` fehlte bis v1.3.2.
     *
     * @param class-string $endpointClass
     */
    #[DataProvider('documentEndpoints')]
    public function test_document_file_subresource(string $endpointClass, string $path): void {
        $this->handler->append(new Response(200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="RE1019.pdf"',
        ], '%PDF-1.7'));

        /** @var InvoicesEndpoint|DownPaymentInvoicesEndpoint $endpoint */
        $endpoint = new $endpointClass($this->client());
        $file = $endpoint->downloadContent(new VoucherID(self::VOUCHER_ID), 'application/pdf');

        $request = $this->lastRequest();
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame("https://api.lexware.io/v1/{$path}/" . self::VOUCHER_ID . '/file', (string) $request->getUri());
        $this->assertSame('application/pdf', $request->getHeaderLine('Accept'));
        $this->assertSame('%PDF-1.7', $file->getContent());
        $this->assertSame('RE1019.pdf', $file->getFileName());
    }

    /**
     * Bis v1.3.2 warf render() „Name documentFileId does not match entity
     * name id“: der Entity-Name wurde erst nach der Prüfung gesetzt.
     */
    public function test_render_reads_the_document_file_id(): void {
        $this->respondJson(200, ['documentFileId' => 'b26e1d73-19ff-46b1-8929-09d8d73d4167']);

        $fileId = (new InvoicesEndpoint($this->client()))->render(new VoucherID(self::VOUCHER_ID));

        $this->assertSame('https://api.lexware.io/v1/invoices/' . self::VOUCHER_ID . '/document', (string) $this->lastRequest()->getUri());
        $this->assertInstanceOf(DocumentFileID::class, $fileId);
        $this->assertSame('b26e1d73-19ff-46b1-8929-09d8d73d4167', $fileId->toString());
        $this->assertSame(['documentFileId' => 'b26e1d73-19ff-46b1-8929-09d8d73d4167'], $fileId->toArray());
    }
}
