<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Contracts\Interfaces\NamedValueInterface;

abstract class NamedValue implements NamedValueInterface {
    protected string $entityName;
    protected $value;

    protected bool $readOnly = false;

    public function __construct($data = null) {
        if (empty($this->entityName))
            $this->entityName = static::class;
        $this->value = $this->validateData($data);
    }

    public function getEntityName(): string {
        return $this->entityName;
    }

    public function getValue() {
        return $this->value;
    }

    public function setData($data): NamedEntityInterface {
        if ($this->readOnly) {
            throw new \RuntimeException("Cannot modify read-only value.");
        }
        $this->value = $this->validateData($data);
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
        } elseif (is_array($data) && empty($data)) {
            return null;
        } elseif (!is_scalar($data) && !is_null($data)) {
            throw new \InvalidArgumentException("Value must be a scalar or null.");
        }
        return $data;
    }

    public function toArray(): array {
        $result = [];
        if (is_array($this->value)) {
            foreach ($this->value as $key => $value) {
                if ($value instanceof NamedEntityInterface) {
                    $result[] = $value->toArray();
                } else {
                    $result[$key] = $value;
                }
            }
        } else {
            $result[$this->entityName] = $this->value;
        }
        return $result;
    }

    public function toJson(): string {
        return json_encode($this->toArray(), JSON_FORCE_OBJECT);
    }

    public function toString(): string {
        return (string) $this->value;
    }

    public static function fromArray(array $data): self {
        $className = get_called_class();
        return new $className($data);
    }

    public static function fromJson(string $data): self {
        return self::fromArray(json_decode($data, true));
    }
}
