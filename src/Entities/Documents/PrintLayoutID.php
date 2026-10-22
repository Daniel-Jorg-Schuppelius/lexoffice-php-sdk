<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PrintLayoutID.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Entities\PrintLayouts\PrintLayoutID as PrintLayoutsPrintLayoutID;
use Psr\Log\LoggerInterface;

class PrintLayoutID extends PrintLayoutsPrintLayoutID {
    /**
     * @param mixed $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = 'printLayoutId';
        parent::__construct($data, $logger);
    }
}
