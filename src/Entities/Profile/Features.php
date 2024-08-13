<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use Lexoffice\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class Features extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = Feature::class;
        parent::__construct($data, $logger);
    }
}
