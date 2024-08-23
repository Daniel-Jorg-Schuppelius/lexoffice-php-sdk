<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use DateTime;
use Lexoffice\Contracts\Interfaces\ExtendedTimestampableInterface;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableInterface;
use Lexoffice\Contracts\Interfaces\VersionableInterface;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Version;
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

abstract class NamedDocument extends NamedEntity implements IdentifiableInterface, OrganizationIdentifiableInterface, ExtendedTimestampableInterface, VersionableInterface {
    protected ?ID $id;
    protected ?OrganizationID $organizationId;
    protected ?DateTime $createdDate;
    protected ?DateTime $updatedDate;
    protected ?Version $version;
    public ?Language $language;
    protected ?bool $archived;
    protected ?VoucherStatus $voucherStatus;
    protected ?string $voucherNumber;
    public DateTime $voucherDate;
    public Address $address;
    public ?TotalPrice $totalPrice;
    protected ?TaxAmounts $taxAmounts;
    public TaxConditions $taxConditions;
    protected ?RelatedVouchers $relatedVouchers;
    public ?PrintLayoutID $printLayoutId;
    public ?string $title;
    public ?string $introduction;
    public ?string $remark;
    protected ?DocumentFile $files;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): ID {
        return $this->id;
    }

    public function getOrganizationID(): OrganizationID {
        return $this->organizationId;
    }

    public function getCreatedDate(): ?DateTime {
        return $this->createdDate;
    }

    public function getUpdatedDate(): ?DateTime {
        return $this->updatedDate;
    }

    public function getVersion(): Version {
        return $this->version;
    }
}
