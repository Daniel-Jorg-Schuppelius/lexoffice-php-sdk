<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : FilesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\Entities\Files\File;
use Lexoffice\Entities\Files\FileResource;

class FilesEndpoint extends EndpointAbstract {
    protected string $endpoint = 'files';

    public function upload(File $file): FileResource {
        self::logDebug('Uploading file', ['filePath' => $file->getFilePath()]);

        return self::logInfoWithTimer(function () use ($file) {
            $response = $this->client->post($this->getEndpointUrl(), [
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
        }, 'File uploaded');
    }

    public function download(ID $id, string $path): File {
        self::logDebug('Downloading file', ['id' => $id->toString(), 'path' => $path]);

        return self::logInfoWithTimer(function () use ($id, $path) {
            $response = $this->client->get("{$this->getEndpointUrl()}/{$id->toString()}");

            $body = $this->handleResponse($response, 200);

            $contentDisposition = $response->getHeader('Content-Disposition')[0];
            preg_match('/filename[^;=\n]*=((["\']).*?\2|[^;\n]*)/', $contentDisposition, $matches);
            $filePath = $path . (substr($path, -1) !== '/' || substr($path, -1) !== '\\' ? '/' : '') . $matches[1] ?? 'downloaded_file';

            file_put_contents($filePath, base64_decode($body));

            return new File([
                'id' => $id->toString(),
                'filePath' => $filePath,
            ]);
        }, "File downloaded (ID: {$id->toString()})");
    }

    public function get(?ID $id = null): File {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting a file');
        }

        return $this->download($id, sys_get_temp_dir());
    }
}
