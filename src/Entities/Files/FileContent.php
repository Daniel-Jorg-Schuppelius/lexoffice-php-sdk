<?php
/*
 * Created on   : Wed Oct 21 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : FileContent.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use Psr\Http\Message\ResponseInterface;

/**
 * Heruntergeladene Datei im Speicher: Inhalt, Medientyp aus `Content-Type`
 * und vorgeschlagener Name aus `Content-Disposition`.
 */
class FileContent {
    public function __construct(
        private readonly string $content,
        private readonly ?string $contentType = null,
        private readonly ?string $fileName = null
    ) {}

    public static function fromResponse(ResponseInterface $response, string $content): self {
        $contentType = $response->getHeaderLine('Content-Type');
        $disposition = $response->getHeaderLine('Content-Disposition');

        $fileName = null;
        if (preg_match('/filename[^;=\n]*=(["\']?)(.*?)\1(?:;|$)/', $disposition, $matches) && $matches[2] !== '') {
            $fileName = basename(trim($matches[2]));
        }

        return new self($content, $contentType !== '' ? $contentType : null, $fileName);
    }

    public function getContent(): string {
        return $this->content;
    }

    /** Medientyp ohne Parameter, z. B. `application/pdf`. */
    public function getMimeType(): ?string {
        if ($this->contentType === null) {
            return null;
        }

        return strtolower(trim(explode(';', $this->contentType, 2)[0]));
    }

    /** Vollständiger `Content-Type`-Header, z. B. `application/xml;charset=UTF-8`. */
    public function getContentType(): ?string {
        return $this->contentType;
    }

    public function getFileName(): ?string {
        return $this->fileName;
    }

    public function getSize(): int {
        return strlen($this->content);
    }
}
