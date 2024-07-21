<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

abstract class NamedValueList extends NamedValue {
    protected string $className;
    protected $data = [];

    public function __construct($data = null) {
        $this->name = static::class;
        $this->readOnly = false;
        $this->data = $this->validateData($data);
    }

    protected function validateData($data) {
        $result = [];
        if (is_array($data)) {
            foreach ($data as $item) {
                if (!is_scalar($item) && !is_array($item)) {
                    throw new \InvalidArgumentException("Value must be an array of scalars, or a nested array.");
                }
                $result[] =  new $this->className($item);
            }
        } else {
            $result[] = $data;
        }
        return $result;
    }
}
