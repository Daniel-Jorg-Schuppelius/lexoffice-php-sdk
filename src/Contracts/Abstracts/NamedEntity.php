<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use ReflectionClass;
use ReflectionNamedType;
use BackedEnum;
use DateTime;

abstract class NamedEntity implements NamedEntityInterface {
    protected string $entityName;
    protected string $className;

    public function __construct($data = null) {
        $this->entityName = static::class;

        if (!is_null($data)) {
            $this->setData($data);
        } else {
            $this->initialize();
        }
    }

    public function getEntityName(): string {
        return $this->entityName;
    }

    public function setData($data): NamedEntityInterface {
        if (is_array($data)) {
            $reflectionClass = new ReflectionClass($this);
            foreach ($data as $key => $val) {
                if (is_numeric($key) || !$reflectionClass->hasProperty($key)) {
                    error_log("The property $key does not exist in " . static::class);
                    continue;
                }

                $property = $reflectionClass->getProperty($key);
                $type = $property->getType();

                if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                    $className = $type->getName();

                    if (is_subclass_of($className, BackedEnum::class)) {
                        $this->{$key} = $className::from($val);
                    } else if ($key == "content" && !empty($this->className) && is_subclass_of($className, NamedEntityInterface::class)) {
                        $this->{$key} = new $this->className($val);
                    } else {
                        try {
                            if (is_null($val)) {
                                $this->{$key} = null;
                            } else {
                                $this->{$key} = new $className($val);
                            }
                        } catch (\Throwable $e) {
                            throw new \UnexpectedValueException("Failed to instantiate $className: " . $e->getMessage());
                        }
                    }
                } else {
                    $this->{$key} = $val;
                }
            }
        } else {
            throw new \InvalidArgumentException("Data must be an array.");
        }

        return $this;
    }

    protected function initialize() {
        $reflectionClass = new ReflectionClass($this);
        foreach ($reflectionClass->getProperties() as $property) {
            $type = $property->getType();
            if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                $className = $type->getName();

                if (is_subclass_of($className, BackedEnum::class)) {
                    $this->{$property->getName()} = $className::from(current($className::cases())->value);
                } else {
                    try {
                        $this->{$property->getName()} = new $className();
                    } catch (\Throwable $e) {
                        error_log("Failed to instantiate $className: " . $e->getMessage());
                    }
                }
            }
        }
    }

    public function toArray(): array {
        $result = [];
        $excluded = get_class_vars(get_parent_class($this));

        foreach (get_object_vars($this) as $key => $value) {
            if (array_key_exists($key, $excluded)) {
                continue;
            }

            if ($value instanceof NamedEntityInterface) {
                $valueArray = $value->toArray();
                $result[$key] = $value instanceof NamedValue && isset($valueArray[$key]) ? $valueArray[$key] : $valueArray;
            } elseif ($value instanceof BackedEnum) {
                $result[$key] = $value->value;
            } elseif ($value instanceof DateTime) {
                $result[$key] = $value->format(DateTime::RFC3339_EXTENDED);
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
}
