<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use APIToolkit\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class BusinessFeatures extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = BusinessFeature::class;
        parent::__construct($data, $logger);
    }
}
