<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ExtendedTimestampableNamedEntityInterface.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces;

use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\TimestampableNamedEntityInterface;
use DateTime;

interface ExtendedTimestampableNamedEntityInterface extends TimestampableNamedEntityInterface {
    public function getUpdatedDate(): ?DateTime;
}
