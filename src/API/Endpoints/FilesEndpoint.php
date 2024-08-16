<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Entities\Files\File;
use Lexoffice\Entities\Files\FileResource;
use Lexoffice\Entities\ID;

class FilesEndpoint extends BaseEndpointAbstract {
    protected string $endpoint = 'files';

    public function upload(File $file): FileResource {
        $response = $this->client->post($this->endpoint, [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($file->getFilePath(), 'r'),
                    'filename' => basename($file->getFilePath()),
                ],
                [
                    'name'     => 'type',
                    'contents' => 'voucher',
                ],
            ],
            'timeout' => 120,
        ]);
        $body = $this->handleResponse($response, 202);

        return FileResource::fromJson($body);
    }

    public function download(ID $id, string $path): File {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");

        $body = $this->handleResponse($response, 200);

        $contentDisposition = $response->getHeader('Content-Disposition')[0];
        preg_match('/filename[^;=\n]*=((["\']).*?\2|[^;\n]*)/', $contentDisposition, $matches);
        $filePath = $path . (substr($path, -1) !== '/' || substr($path, -1) !== '\\' ? '/' : '') . $matches[1] ?? 'downloaded_file';

        file_put_contents($filePath, base64_decode($body));

        return new File([
            'id' => $id->toString(),
            'filePath' => $filePath,
        ]);
    }

    public function get(ID $id): File {
        return $this->download($id, sys_get_temp_dir());
    }
}
