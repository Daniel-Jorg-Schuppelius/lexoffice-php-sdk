<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use Lexoffice\Entities\ID;
use Lexoffice\Entities\OrganizationID;
use Lexoffice\Entities\Version;
use Lexoffice\Entities\Document\Address;
use Lexoffice\Entities\Document\LineItems;
use Lexoffice\Entities\Document\TotalPrice;
use Lexoffice\Entities\Document\TaxConditions;
use Lexoffice\Entities\Document\PrintLayoutID;
use Lexoffice\Entities\Document\Files;
use Lexoffice\Entities\Document\RelatedVouchers;
use Lexoffice\Entities\Document\TaxAmounts;
use Lexoffice\Enums\Language;
use Lexoffice\Enums\VoucherStatus;

abstract class NamedDocument extends NamedEntity {
    protected ID $id;
    protected OrganizationID $organizationId;
    protected \DateTime $createdDate;
    protected \DateTime $updatedDate;
    protected Version $version;
    public Language $language;
    protected bool $archived;
    public VoucherStatus $voucherStatus;
    protected string $voucherNumber;
    public \DateTime $voucherDate;
    public Address $address;
    public LineItems $lineItems;
    public TotalPrice $totalPrice;
    protected TaxAmounts $taxAmounts;
    protected TaxConditions $taxConditions;
    protected RelatedVouchers $relatedVouchers;
    protected PrintLayoutID $printLayoutId;
    protected string $title;
    protected string $introduction;
    protected string $remark;
    protected Files $files;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
