<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\ArchivableNamedEntityInterface;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\IdentifiableNamedEntityInterface;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\VersionableNamedEntityInterface;
use APIToolkit\Entities\ID;
use APIToolkit\Entities\Version;
use DateTime;
use Lexoffice\Contracts\Interfaces\ExtendedTimestampableNamedEntityInterface;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableNamedEntityInterface;
use Lexoffice\Entities\Documents\Address;
use Lexoffice\Entities\Documents\TotalPrice;
use Lexoffice\Entities\Documents\TaxConditions;
use Lexoffice\Entities\Documents\PrintLayoutID;
use Lexoffice\Entities\Documents\DocumentFile;
use Lexoffice\Entities\Documents\RelatedVouchers;
use Lexoffice\Entities\Documents\TaxAmounts;
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Enums\Language;
use Lexoffice\Enums\VoucherStatus;
use Psr\Log\LoggerInterface;

abstract class NamedDocument extends NamedEntity implements IdentifiableNamedEntityInterface, OrganizationIdentifiableNamedEntityInterface, ArchivableNamedEntityInterface, ExtendedTimestampableNamedEntityInterface, VersionableNamedEntityInterface {
    protected ?ID $id;
    protected ?OrganizationID $organizationId;
    protected ?DateTime $createdDate;
    protected ?DateTime $updatedDate;
    protected ?Version $version;
    protected ?Language $language;
    protected ?bool $archived;
    protected ?VoucherStatus $voucherStatus;
    protected ?string $voucherNumber;
    protected DateTime $voucherDate;
    protected Address $address;
    protected ?TotalPrice $totalPrice;
    protected ?TaxAmounts $taxAmounts;
    protected TaxConditions $taxConditions;
    protected ?RelatedVouchers $relatedVouchers;
    protected ?PrintLayoutID $printLayoutId;
    protected ?string $title;
    protected ?string $introduction;
    protected ?string $remark;
    protected ?DocumentFile $files;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function isArchived(): bool {
        return $this->archived ?? false;
    }

    public function getID(): ?ID {
        return $this->id ?? null;
    }

    public function getOrganizationID(): ?OrganizationID {
        return $this->organizationId ?? null;
    }

    public function getCreatedDate(): ?DateTime {
        return $this->createdDate ?? null;
    }

    public function getUpdatedDate(): ?DateTime {
        return $this->updatedDate ?? null;
    }

    public function getVersion(): ?Version {
        return $this->version ?? null;
    }

    public function getLanguage(): ?Language {
        return $this->language ?? null;
    }

    public function getVoucherStatus(): ?VoucherStatus {
        return $this->voucherStatus ?? null;
    }

    public function getVoucherNumber(): ?string {
        return $this->voucherNumber ?? null;
    }

    public function getVoucherDate(): DateTime {
        return $this->voucherDate;
    }

    public function getAddress(): Address {
        return $this->address;
    }

    public function getTotalPrice(): ?TotalPrice {
        return $this->totalPrice ?? null;
    }

    public function getTaxAmounts(): ?TaxAmounts {
        return $this->taxAmounts ?? null;
    }

    public function getTaxConditions(): TaxConditions {
        return $this->taxConditions;
    }

    public function getRelatedVouchers(): ?RelatedVouchers {
        return $this->relatedVouchers ?? null;
    }

    public function getPrintLayoutId(): ?PrintLayoutID {
        return $this->printLayoutId ?? null;
    }

    public function getTitle(): ?string {
        return $this->title ?? null;
    }

    public function getIntroduction(): ?string {
        return $this->introduction ?? null;
    }

    public function getRemark(): ?string {
        return $this->remark ?? null;
    }

    public function getFiles(): ?DocumentFile {
        return $this->files ?? null;
    }
}
