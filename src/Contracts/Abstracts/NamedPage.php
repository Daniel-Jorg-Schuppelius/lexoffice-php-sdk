<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\NamedValuesInterface;
use Lexoffice\Entities\Collations;

abstract class NamedPage extends NamedEntity {
    protected NamedValuesInterface $content;
    protected bool $first;
    protected bool $last;
    protected int $totalPages;
    protected int $totalElements;
    protected int $size;
    protected int $number;
    protected int $numberOfElements;
    protected Collations $sort;

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function isFirst(): bool {
        return $this->first;
    }

    public function isLast(): bool {
        return $this->last;
    }

    public function getTotalPages(): int {
        return $this->totalPages;
    }

    public function getTotalElements(): int {
        return $this->totalElements;
    }

    public function getSize(): int {
        return $this->size;
    }

    public function getNumber(): int {
        return $this->number;
    }

    public function getNumberOfElements(): int {
        return $this->numberOfElements;
    }

    public function getSort(): Collations {
        return $this->sort;
    }

    public function getContent(): NamedValuesInterface {
        return $this->content;
    }

    public function getValues() {
        return $this->content->getValues();
    }
}
