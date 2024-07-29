<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

abstract class NamedValueList extends NamedValue {
    protected string $className = string::class;
    protected $data = [];

    public function __construct($data = null) {
        if (!empty($data) && isset($this->entityName) && $this->entityName == "content" && array_key_exists($this->entityName, $data)) {
            parent::__construct($data[$this->entityName]);
        } else {
            parent::__construct($data);
        }
    }

    public function getData() {
        return $this->data;
    }

    protected function validateData($data) {
        $result = [];
        if (is_array($data)) {
            foreach ($data as $item) {
                if (!is_scalar($item) && !is_array($item) && !is_null($item)) {
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
