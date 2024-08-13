<?php

declare(strict_types=1);

namespace Lexoffice\Entities;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\SortDirection;
use Psr\Log\LoggerInterface;

class Sort extends NamedEntity {
    protected SortDirection $direction;
    protected string $property;
    protected bool $ignoreCase;
    protected string $nullHandling;
    protected bool $ascending;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        if (is_array($data) && count($data) == 1) {
            $data = $data[0];
        }
        parent::__construct($data, $logger);
    }
}
