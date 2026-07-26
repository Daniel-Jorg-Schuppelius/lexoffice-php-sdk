<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : File.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\IdentifiableNamedEntityInterface;
use Psr\Log\LoggerInterface;

class File extends NamedEntity implements IdentifiableNamedEntityInterface {
    public const ALLOWED_EXTENSIONS = ['pdf', 'jpg', 'png'];

    protected ?FileID $id;
    protected ?string $filePath;

    /**
     * @param array<string, mixed>|object|null $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): ?FileID {
        return $this->id ?? null;
    }

    public function getFilePath(): ?string {
        return $this->filePath;
    }

    public function getFileSize(): int {
        if (!isset($this->filePath) || !is_file($this->filePath)) {
            return 0;
        }
        $size = filesize($this->filePath);

        return $size === false ? 0 : $size;
    }

    public function isValid(): bool {
        if (isset($this->filePath) && file_exists($this->filePath)) {
            $extension = strtolower(pathinfo($this->filePath, PATHINFO_EXTENSION));

            if (in_array($extension, self::ALLOWED_EXTENSIONS)) {
                if ($this->getFileSize() <= 5000000) {
                    return true;
                }
            }
        }
        return isset($this->id);
    }
}
