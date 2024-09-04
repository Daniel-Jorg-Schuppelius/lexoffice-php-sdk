<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Psr\Log\LoggerInterface;

class ContactPerson extends Person {
    protected ?bool $primary;
    protected ?string $emailAddress;
    protected ?string $phoneNumber;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function isPrimary(): bool {
        return $this->primary ?? false;
    }

    public function getEmailAddress(): ?string {
        return $this->emailAddress ?? null;
    }

    public function getPhoneNumber(): ?string {
        return $this->phoneNumber ?? null;
    }

    public function setPrimary(bool $primary): void {
        $this->primary = $primary;
    }

    public function setEmailAddress(string $emailAddress): void {
        $this->emailAddress = $emailAddress;
    }

    public function setPhoneNumber(string $phoneNumber): void {
        $this->phoneNumber = $phoneNumber;
    }
}
