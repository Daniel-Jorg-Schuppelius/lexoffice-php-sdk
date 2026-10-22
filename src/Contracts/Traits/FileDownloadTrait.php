<?php
/*
 * Created on   : Wed Oct 21 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : FileDownloadTrait.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Contracts\Traits;

use Lexoffice\Entities\Files\FileContent;

/**
 * Binärer Download, gemeinsam für `files/{id}` und `{beleg}/{id}/file`.
 *
 * Der `Accept`-Header wählt die Darstellung: der Platzhalter für alle Typen
 * liefert die Standarddatei, `application/xml` das XML einer XRechnung,
 * `application/pdf` das PDF. Der Client-Standard `application/json` passt
 * hier nicht (Lexware antwortet mit 406).
 */
trait FileDownloadTrait {
    protected function fetchFileContent(string $url, string $accept): FileContent {
        self::logDebug('Downloading file', ['url' => $url, 'accept' => $accept]);

        return self::logInfoWithTimer(function () use ($url, $accept) {
            $response = $this->client->get($url, ['headers' => ['Accept' => $accept]]);
            $content = $this->handleResponse($response, 200);

            return FileContent::fromResponse($response, $content);
        }, 'File downloaded');
    }
}
