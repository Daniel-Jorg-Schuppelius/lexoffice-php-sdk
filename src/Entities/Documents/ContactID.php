<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ContactID.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Entities\Contacts\ContactID as ContactsContactID;
use Psr\Log\LoggerInterface;

/**
 * Kontakt-ID in der Belegadresse. Der Entity-Name entspricht dem Feld
 * `contactId`, damit sie als Zeichenkette serialisiert wird.
 */
class ContactID extends ContactsContactID {
    /**
     * @param mixed $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = 'contactId';
        parent::__construct($data, $logger);
    }
}
