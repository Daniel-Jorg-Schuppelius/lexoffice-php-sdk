<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ConnectionID.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use Lexoffice\Contracts\Abstracts\UuidID;
use Psr\Log\LoggerInterface;

class ConnectionID extends UuidID {
    /**
     * @param mixed $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = 'connectionId';
        parent::__construct($data, $logger);
    }
}
