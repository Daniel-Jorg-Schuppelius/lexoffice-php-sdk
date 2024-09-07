<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Psr\Log\LoggerInterface;

class Company extends NamedEntity {
    protected ?bool $allowTaxFreeInvoices;
    protected string $name;
    protected ?string $taxNumber;
    protected ?string $vatRegistrationId;
    protected ContactPersons $contactPersons;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getAllowTaxFreeInvoices(): ?bool {
        return $this->allowTaxFreeInvoices ?? null;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getTaxNumber(): ?string {
        return $this->taxNumber ?? null;
    }

    public function getVatRegistrationId(): ?string {
        return $this->vatRegistrationId ?? null;
    }

    public function getContactPersons(): ContactPersons {
        return $this->contactPersons;
    }

    public function setAllowTaxFreeInvoices(bool $allowTaxFreeInvoices): void {
        $this->allowTaxFreeInvoices = $allowTaxFreeInvoices;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setTaxNumber(string $taxNumber): void {
        $this->taxNumber = $taxNumber;
    }

    public function setVatRegistrationId(string $vatRegistrationId): void {
        $this->vatRegistrationId = $vatRegistrationId;
    }

    public function setContactPersons(ContactPersons $contactPersons): void {
        $this->contactPersons = $contactPersons;
    }
}
