<?php

declare(strict_types=1);

namespace Lexoffice\Entities;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\SortDirection;

class Sort extends NamedEntity {
    protected SortDirection $direction;
    protected string $property;
    protected bool $ignoreCase;
    protected string $nullHandling;
    protected bool $ascending;

    public function __construct($data = null) {
        if (is_array($data) && count($data) == 1) {
            $data = $data[0];
        }
        parent::__construct($data);
    }
}
