<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Countries;

use APIToolkit\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class Countries extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = Country::class;
        parent::__construct($data, $logger);
    }
}
