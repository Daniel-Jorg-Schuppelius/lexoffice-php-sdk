<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Role.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Contracts\Abstracts\NamedValue;
use Psr\Log\LoggerInterface;

class Role extends NamedValue {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = 'number';
        parent::__construct($data, $logger);
    }

    public function toArray(): array {
        if (is_null($this->value)) {
            return [];
        }
        return [
            $this->entityName => $this->value
        ];
    }
}
