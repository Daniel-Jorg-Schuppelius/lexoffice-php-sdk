<?php
/*
 * Created on   : Sat Oct 10 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ContactID.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use Lexoffice\Entities\Contacts\ContactID as ContactsContactID;
use Psr\Log\LoggerInterface;

/**
 * Kontakt-ID am Beleg. Der Entity-Name entspricht dem Feld `contactId`, damit
 * sie als Zeichenkette serialisiert wird und nicht als `{"id": …}`.
 */
class ContactID extends ContactsContactID {
    /**
     * @param mixed $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
        $this->entityName = 'contactId';
    }
}
