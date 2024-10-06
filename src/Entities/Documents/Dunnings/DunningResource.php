<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DunningResource.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Dunnings;

use Lexoffice\Contracts\Abstracts\ResourceAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;

class DunningResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new Dunning();
    }
}
