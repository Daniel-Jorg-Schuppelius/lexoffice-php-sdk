<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ContactPerson.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Psr\Log\LoggerInterface;

class ContactPerson extends Person {
    protected ?bool $primary;
    protected ?EmailAddress $emailAddress;
    protected ?PhoneNumber $phoneNumber;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function isPrimary(): bool {
        return $this->primary ?? false;
    }

    public function getEmailAddress(): ?EmailAddress {
        return $this->emailAddress ?? null;
    }

    public function getPhoneNumber(): ?PhoneNumber {
        return $this->phoneNumber ?? null;
    }

    public function setPrimary(bool $primary): void {
        $this->primary = $primary;
    }

    public function setEmailAddress(EmailAddress $emailAddress): void {
        $this->emailAddress = $emailAddress;
    }

    public function setPhoneNumber(PhoneNumber $phoneNumber): void {
        $this->phoneNumber = $phoneNumber;
    }
}
