<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Psr\Log\LoggerInterface;

class Address extends \Lexoffice\Entities\Address {
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
