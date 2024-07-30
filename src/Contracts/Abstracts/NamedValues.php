<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Contracts\Interfaces\NamedValueInterface;
use Lexoffice\Contracts\Interfaces\NamedValuesInterface;

abstract class NamedValues implements NamedValuesInterface {
    protected string $valueClassName = string::class;
    protected string $entityName;
    protected array $values = [];

    protected bool $readOnly = false;

    public function __construct($data = null) {
        if (!empty($data) && isset($this->entityName) && $this->entityName == "content" && array_key_exists($this->entityName, $data)) {
            $this->values = $this->validateData($data[$this->entityName]);
        } else {
            $this->values = $this->validateData($data);
        }
    }

    public function getEntityName(): string {
        return $this->entityName;
    }

    public function getValues(): array {
        return $this->values;
    }

    public function isReadOnly(): bool {
        return $this->readOnly;
    }

    public function setData($data): NamedEntityInterface {
        if ($this->readOnly) {
            throw new \RuntimeException("Cannot modify read-only value.");
        }
        $this->values = $this->validateData($data);
        return $this;
    }

    protected function validateData($data) {
        $result = [];
        if (is_array($data)) {
            foreach ($data as $item) {
                if (is_scalar($item) || is_array($item) || is_null($item)) {
                    $result[] = new $this->valueClassName($item);
                } else {
                    throw new \InvalidArgumentException("Value must be an array of scalars, or a nested array.");
                }
            }
        } else {
            $result[] = $data;
        }
        return $result;
    }

    protected function isArrayFullyNumeric($array) {
        // Extrahiere alle Schlüssel des Arrays
        $keys = array_keys($array);

        // Filtere die Schlüssel, die keine Integers sind
        $nonNumericKeys = array_filter($keys, function ($key) {
            return !is_int($key);
        });

        // Wenn das Array $nonNumericKeys leer ist, sind alle Schlüssel numerisch
        return count($nonNumericKeys) === 0;
    }

    public function toArray(): array {
        $result = [];
        foreach ($this->values as $key => $value) {
            if ($value instanceof NamedValueInterface && $value->getEntityName() == $this->valueClassName) {
                $result[] = $value->getValue();
            } elseif ($value instanceof NamedEntityInterface) {
                $result[] = $value->toArray();
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    public function toJson(): string {
        return json_encode($this->toArray(), JSON_FORCE_OBJECT);
    }

    public static function fromArray(array $data): self {
        $className = get_called_class();
        return new $className($data);
    }

    public static function fromJson(string $data): self {
        return self::fromArray(json_decode($data, true));
    }
}
