<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : FilesEndpointTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Tests\Endpoints;

use Lexoffice\API\Endpoints\FilesEndpoint;
use Lexoffice\Entities\Files\{File, FileResource};
use Tests\Contracts\EndpointTest;

class FilesEndpointTest extends EndpointTest {
    private FilesEndpoint $endpoint;

    protected function setUp(): void {
        $this->apiDisabled = true; // API is disabled
        parent::setUp();
        $this->endpoint = new FilesEndpoint($this->client);
    }

    public function test_upload_and_download_files_api(): void {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            'filePath' => __DIR__ . '/../../.samples/sample.pdf',
        ];

        $fileResource = $this->endpoint->upload(new File($data));
        $this->assertInstanceOf(FileResource::class, $fileResource);
        $file = $this->endpoint->get($fileResource->getID());
        $this->assertInstanceOf(File::class, $file);
        $filePath = $file->getFilePath();
        $this->assertNotNull($filePath);
        $this->assertEquals(file_get_contents($data['filePath']), file_get_contents($filePath));
    }
}
