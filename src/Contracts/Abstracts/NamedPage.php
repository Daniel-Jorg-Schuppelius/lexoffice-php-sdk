<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\NamedValueInterface;
use Lexoffice\Entities\Sort;

abstract class NamedPage extends NamedEntity {
    protected NamedValueInterface $content;
    protected bool $first;
    protected bool $last;
    protected int $totalPages;
    protected int $totalElements;
    protected int $size;
    protected int $number;
    protected int $numberOfElements;
    protected Sort $sort;

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getContent(): NamedValueInterface {
        return $this->content;
    }

    public function getData() {
        return $this->content->getData();
    }
}
