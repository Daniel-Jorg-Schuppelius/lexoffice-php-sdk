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
use Lexoffice\Entities\Files\{File, FileResource};

class FilesEndpoint extends EndpointAbstract {
    protected string $endpoint = 'files';

    public const UPLOAD_TIMEOUT = 120.0;

    public function upload(File $file): FileResource {
        $filePath = $file->getFilePath();

        if ($filePath === null || !is_file($filePath) || !is_readable($filePath)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'File to upload does not exist or is not readable');
        }

        self::logDebug('Uploading file', ['filePath' => $filePath]);

        return self::logInfoWithTimer(function () use ($filePath) {
            $handle = fopen($filePath, 'r');
            if ($handle === false) {
                self::logErrorAndThrow(InvalidArgumentException::class, 'Unable to open file for upload');
            }

            // Uploads need a generous timeout. The underlying client overrides the
            // per-request "timeout" option with its own configured timeout, so raise
            // the client timeout for the duration of the upload (and restore it).
            $previousTimeout = null;
            if (method_exists($this->client, 'getTimeout') && method_exists($this->client, 'setTimeout')) {
                $previousTimeout = $this->client->getTimeout();
                if ($previousTimeout < self::UPLOAD_TIMEOUT) {
                    $this->client->setTimeout(self::UPLOAD_TIMEOUT);
                }
            }

            try {
                $response = $this->client->post($this->getEndpointUrl(), [
                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => $handle,
                            'filename' => basename($filePath),
                        ],
                        [
                            'name' => 'type',
                            'contents' => 'voucher',
                        ],
                    ],
                    'timeout' => self::UPLOAD_TIMEOUT,
                ]);
            } finally {
                if ($previousTimeout !== null && method_exists($this->client, 'setTimeout')) {
                    $this->client->setTimeout($previousTimeout);
                }
                if (is_resource($handle)) {
                    fclose($handle);
                }
            }

            $body = $this->handleResponse($response, 202);

            return FileResource::fromJson($body);
        }, 'File uploaded');
    }

    public function download(ID $id, string $path): File {
        self::logDebug('Downloading file', ['id' => $id->toString(), 'path' => $path]);

        return self::logInfoWithTimer(function () use ($id, $path) {
            $response = $this->client->get("{$this->getEndpointUrl()}/{$id->toString()}");

            $body = $this->handleResponse($response, 200);

            $contentDisposition = $response->getHeader('Content-Disposition')[0] ?? '';
            $fileName = 'downloaded_file';
            if (preg_match('/filename[^;=\n]*=(["\']?)(.*?)\1(?:;|$)/', $contentDisposition, $matches) && $matches[2] !== '') {
                $fileName = basename(trim($matches[2]));
            }

            $lastChar = substr($path, -1);
            $separator = ($lastChar === '/' || $lastChar === '\\') ? '' : '/';
            $filePath = $path . $separator . $fileName;

            file_put_contents($filePath, $body);

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
