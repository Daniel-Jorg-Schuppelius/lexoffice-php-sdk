<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Contracts\Interfaces\NamedValueInterface;

abstract class NamedValue implements NamedValueInterface {
    protected string $entityName;
    protected $data;

    protected bool $readOnly = false;

    public function __construct($data = null) {
        if (empty($this->entityName))
            $this->entityName = static::class;
        $this->data = $this->validateData($data);
    }

    public function getEntityName(): string {
        return $this->entityName;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data): NamedEntityInterface {
        if ($this->readOnly) {
            throw new \RuntimeException("Cannot modify read-only value.");
        }
        $this->data = $this->validateData($data);
        return $this;
    }

    public function isReadOnly(): bool {
        return $this->readOnly;
    }

    protected function validateData($data) {
        if (is_array($data) && count($data) == 1) {
            foreach ($data as $key => $val) {
                if ($key != $this->entityName) {
                    throw new \InvalidArgumentException("Name $key does not exist.");
                }
                return $val;
            }
        } else if (!is_scalar($data) && !is_null($data)) {
            throw new \InvalidArgumentException("Value must be a scalar or null.");
        }
        return $data;
    }
}
