<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Psr\Log\LoggerInterface;

class Person extends NamedEntity {
    protected ?string $salutation;
    protected ?string $firstName;
    protected string $lastName;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getSalutation(): ?string {
        return $this->salutation;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function setSalutation(?string $salutation): void {
        $this->salutation = $salutation;
    }

    public function setFirstName(?string $firstName): void {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }
}