<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : EmailAddresses.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Entities\Contact\EmailAddresses as EmailAddressList;
use Psr\Log\LoggerInterface;

class EmailAddresses extends NamedEntity {
    protected ?EmailAddressList $business;
    protected ?EmailAddressList $office;
    protected ?EmailAddressList $private;
    protected ?EmailAddressList $other;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
