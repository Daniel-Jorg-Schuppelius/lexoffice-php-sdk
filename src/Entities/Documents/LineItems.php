<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : LineItems.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use APIToolkit\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class LineItems extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        if (!is_subclass_of($this->valueClassName, LineItem::class)) {
            $this->valueClassName = LineItem::class;
        }
        parent::__construct($data, $logger);
    }
}
