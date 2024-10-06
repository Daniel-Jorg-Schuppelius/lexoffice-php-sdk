<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : EmailAddress.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Entities\Contact\EmailAddress as ContactEmailAddress;
use Psr\Log\LoggerInterface;

class EmailAddress extends ContactEmailAddress {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = 'emailAddress';
        parent::__construct($data, $logger);
    }
}
