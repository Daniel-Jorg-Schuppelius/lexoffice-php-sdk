<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Psr\Log\LoggerInterface;

class File extends NamedEntity implements IdentifiableInterface {
    public const ALLOWED_EXTENSIONS = ['pdf', 'jpg', 'png'];

    protected ?FileID $id;
    protected ?string $filePath;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): FileID {
        return $this->id;
    }

    public function getFilePath(): ?string {
        return $this->filePath;
    }

    public function getFileSize(): int {
        return filesize($this->filePath);
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
