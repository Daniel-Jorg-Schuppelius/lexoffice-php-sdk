<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use DateTime;
use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\IdentifiableNamedEntityInterface;
use Lexoffice\Contracts\Interfaces\ExtendedTimestampableNamedEntityInterface;
use Lexoffice\Entities\Contacts\ContactID;
use Lexoffice\Enums\VoucherStatus;
use Psr\Log\LoggerInterface;

class BaseVoucher extends NamedEntity implements IdentifiableNamedEntityInterface, ExtendedTimestampableNamedEntityInterface {
    protected ?VoucherID $id;
    protected ?VoucherStatus $voucherStatus;
    protected ?string $voucherNumber;
    protected ?DateTime $voucherDate;
    protected ?DateTime $dueDate;
    protected ?string $contactName;
    protected ?ContactID $contactId;
    protected ?DateTime $createdDate;
    protected ?DateTime $updatedDate;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): VoucherID {
        return $this->id;
    }

    public function getCreatedDate(): ?DateTime {
        return $this->createdDate;
    }

    public function getUpdatedDate(): ?DateTime {
        return $this->updatedDate;
    }

    public function getVoucherStatus(): ?VoucherStatus {
        return $this->voucherStatus;
    }

    public function getVoucherNumber(): ?string {
        return $this->voucherNumber;
    }

    public function getVoucherDate(): ?DateTime {
        return $this->voucherDate;
    }

    public function getDueDate(): ?DateTime {
        return $this->dueDate;
    }

    public function getContactName(): ?string {
        return $this->contactName;
    }

    public function getContactId(): ?ContactID {
        return $this->contactId;
    }

    public function setVoucherStatus(VoucherStatus $voucherStatus): void {
        $this->voucherStatus = $voucherStatus;
    }

    public function setVoucherNumber(string $voucherNumber): void {
        $this->voucherNumber = $voucherNumber;
    }

    public function setVoucherDate(DateTime $voucherDate): void {
        $this->voucherDate = $voucherDate;
    }

    public function setDueDate(DateTime $dueDate): void {
        $this->dueDate = $dueDate;
    }

    public function setContactName(string $contactName): void {
        $this->contactName = $contactName;
    }

    public function setContactId(ContactID $contactId): void {
        $this->contactId = $contactId;
    }
}
