<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PhoneNumber.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Entities\Contact\PhoneNumber as ContactPhoneNumber;
use Psr\Log\LoggerInterface;

class PhoneNumber extends ContactPhoneNumber {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = 'phoneNumber';
        parent::__construct($data, $logger);
    }
}
