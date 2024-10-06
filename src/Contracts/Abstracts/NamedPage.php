<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : NamedPage.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Contracts\Interfaces\NamedValuesInterface;
use Lexoffice\Entities\Collations;
use Psr\Log\LoggerInterface;

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

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
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
