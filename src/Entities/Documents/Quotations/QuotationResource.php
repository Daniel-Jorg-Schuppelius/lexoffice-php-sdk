<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : QuotationResource.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Quotations;

use Lexoffice\Contracts\Abstracts\ResourceAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;

class QuotationResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new Quotation();
    }
}
