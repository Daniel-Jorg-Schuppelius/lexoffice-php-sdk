<?php

namespace Tests\Endpoints;

use Lexoffice\API\Endpoints\FilesEndpoint;
use Lexoffice\Entities\Files\File;
use Lexoffice\Entities\Files\FileResource;
use Tests\Contracts\EndpointTest;

class FilesEndpointTest extends EndpointTest {
    private ?FilesEndpoint $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new FilesEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }

    public function testUploadAndDownloadFilesAPI() {
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
        $this->assertEquals(file_get_contents($data['filePath']), file_get_contents($file->getFilePath()));
    }
}
