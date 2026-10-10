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
use Lexoffice\Contracts\Traits\MultipartUploadTrait;
use Lexoffice\Entities\Files\{File, FileResource};

class FilesEndpoint extends EndpointAbstract {
    use MultipartUploadTrait;

    protected string $endpoint = 'files';

    public const UPLOAD_TIMEOUT = 120.0;

    /**
     * Beleg-Upload (`type=voucher`): Lexware legt dazu selbst einen Beleg an und
     * liefert dessen ID in {@see FileResource::getVoucherId()}. Gehört die Datei
     * zu einem bestehenden Beleg, ist {@see VouchersEndpoint::addFile()} richtig.
     */
    public function upload(File $file): FileResource {
        return $this->uploadMultipart($this->getEndpointUrl(), $file, ['type' => 'voucher'], 202);
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
