<?php
/*
 * Created on   : Sat Oct 10 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : MultipartUploadTrait.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Contracts\Traits;

use InvalidArgumentException;
use Lexoffice\Entities\Files\{File, FileResource};

/**
 * Datei-Upload als multipart/form-data, gemeinsam für `files` und
 * `vouchers/{id}/files`.
 */
trait MultipartUploadTrait {
    /**
     * @param array<string, string> $fields     zusätzliche Formularfelder (z. B. type=voucher)
     * @param int|list<int>         $statusCodes erwartete Antwortcodes
     */
    protected function uploadMultipart(string $url, File $file, array $fields, int|array $statusCodes): FileResource {
        $filePath = $file->getFilePath();

        if ($filePath === null || !is_file($filePath) || !is_readable($filePath)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'File to upload does not exist or is not readable');
        }

        self::logDebug('Uploading file', ['url' => $url, 'filePath' => $filePath]);

        return self::logInfoWithTimer(function () use ($url, $file, $filePath, $fields, $statusCodes) {
            $handle = fopen($filePath, 'r');
            if ($handle === false) {
                self::logErrorAndThrow(InvalidArgumentException::class, 'Unable to open file for upload');
            }

            $multipart = [[
                'name' => 'file',
                'contents' => $handle,
                'filename' => $file->getFileName(),
            ]];
            foreach ($fields as $name => $value) {
                $multipart[] = ['name' => $name, 'contents' => $value];
            }

            try {
                // Uploads brauchen mehr Zeit als ein normaler Request; die
                // per-Request-Option gewinnt gegenüber dem Client-Timeout.
                $response = $this->client->post($url, [
                    'multipart' => $multipart,
                    'timeout' => self::UPLOAD_TIMEOUT,
                ]);
            } finally {
                if (is_resource($handle)) {
                    fclose($handle);
                }
            }

            return FileResource::fromJson($this->handleResponse($response, $statusCodes));
        }, 'File uploaded');
    }
}
