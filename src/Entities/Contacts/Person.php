<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Person.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Entities\Common\Person as CommonPerson;
use Exception;
use Psr\Log\LoggerInterface;

class Person extends CommonPerson {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getMiddleName(): ?string {
        throw new Exception('Middle name is not supported in Lexoffice');
    }

    public function setMiddleName(?string $middleName): void {
        throw new Exception('Middle name is not supported in Lexoffice');
    }
}
