<?php
/*
 * Created on   : Wed Oct 21 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : FileIDs.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use APIToolkit\Contracts\Abstracts\NamedValues;
use DateTime;
use Psr\Log\LoggerInterface;

/**
 * Datei-IDs eines Buchungsbelegs (`vouchers/{id}` → `files`). Die API liefert
 * und erwartet eine Liste von UUIDs; ein PUT ohne bestehende ID löscht die
 * Datei endgültig.
 *
 * @extends NamedValues<FileID>
 */
class FileIDs extends NamedValues {
    /**
     * @param mixed $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = FileID::class;
        parent::__construct($data ?? [], $logger);
    }

    /**
     * @return array<int, mixed>
     */
    protected function getArray(bool $asStringValues = false, bool $dateAsStringValues = true, string $dateFormat = DateTime::RFC3339_EXTENDED): array {
        return array_map(static fn (FileID $id): mixed => $id->getValue(), $this->values);
    }
}
