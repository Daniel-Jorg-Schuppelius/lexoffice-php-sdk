<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Address.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use APIToolkit\Entities\Common\Address as CommonAddress;
use Psr\Log\LoggerInterface;

class Address extends CommonAddress {
    protected ?ContactID $contactId;
    protected ?string $name;
    protected ?ContactID $contactPerson;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function isValid(): bool {
        return (isset($this->name) && !is_null($this->name)) || (isset($this->contactId) && $this->contactId->isValid());
    }

    public function getContactId(): ?ContactID {
        return $this->contactId ?? null;
    }

    public function getName(): ?string {
        return $this->name ?? null;
    }

    public function getContactPerson(): ?ContactID {
        return $this->contactPerson ?? null;
    }

    public function setContactId(ContactID $contactId): void {
        $this->contactId = $contactId;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }
}
