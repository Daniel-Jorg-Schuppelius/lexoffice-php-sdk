<?php
/*
 * Created on   : Sat Jun 14 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : FilesEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\FilesEndpoint;
use Lexoffice\Entities\Files\File;
use Lexoffice\Entities\Files\FileResource;
use Tests\Contracts\OfflineEndpointTest;

class FilesEndpointOfflineTest extends OfflineEndpointTest {
    private FilesEndpoint $endpoint;
    private string $binaryBody;
    private string $tmpDir;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new FilesEndpoint($this->mockClient, $this->logger);
        $this->tmpDir = sys_get_temp_dir() . '/lexoffice-files-test-' . uniqid();
        mkdir($this->tmpDir);
    }

    protected function tearDown(): void {
        parent::tearDown();
        if (is_dir($this->tmpDir)) {
            foreach (glob($this->tmpDir . '/*') ?: [] as $file) {
                @unlink($file);
            }
            @rmdir($this->tmpDir);
        }
    }

    protected function setupMockResponses(): void {
        // Raw binary content that is NOT valid base64; base64_decode() would corrupt it.
        $this->binaryBody = "%PDF-1.4\n\x00\x01\x02\xFF\xFEhello\n";
        $this->mockClient->addResponse(
            'GET',
            'files/*',
            200,
            $this->binaryBody,
            ['Content-Disposition' => 'attachment; filename="invoice.pdf"']
        );
    }

    public function testDownloadWritesRawBodyVerbatim(): void {
        $file = $this->endpoint->download(new ID('abc-123'), $this->tmpDir);

        $this->assertInstanceOf(File::class, $file);
        $this->assertFileExists($file->getFilePath());
        // The raw body must be written unchanged (no base64 decoding / no corruption).
        $this->assertSame($this->binaryBody, file_get_contents($file->getFilePath()));
    }

    public function testDownloadUsesFilenameFromContentDisposition(): void {
        $file = $this->endpoint->download(new ID('abc-123'), $this->tmpDir);

        $this->assertSame('invoice.pdf', basename($file->getFilePath()));
    }

    public function testDownloadJoinsPathWithoutDoubleSlash(): void {
        // Path already ending in a separator must not produce a double slash.
        $file = $this->endpoint->download(new ID('abc-123'), $this->tmpDir . '/');

        $this->assertStringNotContainsString('//', $file->getFilePath());
        $this->assertSame($this->tmpDir . '/invoice.pdf', $file->getFilePath());
    }

    public function testDownloadFallsBackToDefaultFilename(): void {
        $this->mockClient->clearResponses();
        $this->mockClient->addResponse('GET', 'files/*', 200, 'data', []); // no Content-Disposition

        $file = $this->endpoint->download(new ID('no-header'), $this->tmpDir);

        $this->assertSame('downloaded_file', basename($file->getFilePath()));
        $this->assertSame('data', file_get_contents($file->getFilePath()));
    }

    public function testUploadThrowsForMissingFile(): void {
        $this->expectException(InvalidArgumentException::class);

        $this->endpoint->upload(new File(['filePath' => $this->tmpDir . '/does-not-exist.pdf']));
    }

    public function testUploadSucceedsWithExistingFile(): void {
        $this->mockClient->clearResponses();
        $this->mockClient->addResponse('POST', 'files', 202, json_encode(['id' => 'new-file-id']));

        $localFile = $this->tmpDir . '/upload.pdf';
        file_put_contents($localFile, '%PDF-1.4 dummy');

        $resource = $this->endpoint->upload(new File(['filePath' => $localFile]));

        $this->assertInstanceOf(FileResource::class, $resource);
        $this->assertRequestMade('POST', 'files');
    }
}
