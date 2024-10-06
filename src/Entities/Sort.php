<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Sort.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities;

use APIToolkit\Contracts\Abstracts\NamedEntity;
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

    public function getDirection(): SortDirection {
        return $this->direction;
    }

    public function getProperty(): string {
        return $this->property;
    }

    public function getNullHandling(): string {
        return $this->nullHandling;
    }

    public function isAscending(): bool {
        return $this->ascending;
    }

    public function isIgnoreCase(): bool {
        return $this->ignoreCase;
    }
}
