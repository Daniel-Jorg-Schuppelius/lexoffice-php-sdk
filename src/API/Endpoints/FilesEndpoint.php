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
use CommonToolkit\Helper\FileSystem\File as FileHelper;
use InvalidArgumentException;
use Lexoffice\Contracts\Traits\{FileDownloadTrait, MultipartUploadTrait};
use Lexoffice\Entities\Files\{File, FileContent, FileResource};

class FilesEndpoint extends EndpointAbstract {
    use FileDownloadTrait, MultipartUploadTrait;

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

    /**
     * Datei im Speicher, mit Medientyp und vorgeschlagenem Namen. Für
     * E-Rechnungen wählt `application/xml` bzw. `application/pdf` die Darstellung.
     */
    public function downloadContent(ID $id, string $accept = '*/*'): FileContent {
        return $this->fetchFileContent("{$this->getEndpointUrl()}/{$id->toString()}", $accept);
    }

    /**
     * Schreibt die Datei in das Verzeichnis `$path`; der Name kommt aus
     * `Content-Disposition`, sonst `downloaded_file`.
     */
    public function download(ID $id, string $path, string $accept = '*/*'): File {
        $content = $this->downloadContent($id, $accept);

        $lastChar = substr($path, -1);
        $separator = ($lastChar === '/' || $lastChar === '\\') ? '' : '/';
        $filePath = $path . $separator . ($content->getFileName() ?? 'downloaded_file');

        FileHelper::write($filePath, $content->getContent());

        return new File([
            'id' => $id->toString(),
            'filePath' => $filePath,
        ]);
    }

    public function get(?ID $id = null): File {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting a file');
        }

        return $this->download($id, sys_get_temp_dir());
    }
}
