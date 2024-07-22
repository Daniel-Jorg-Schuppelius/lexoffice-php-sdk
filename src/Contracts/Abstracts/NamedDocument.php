<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use DateTime;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\OrganizationID;
use Lexoffice\Entities\Version;
use Lexoffice\Entities\Document\Address;
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
    protected DateTime $createdDate;
    protected DateTime $updatedDate;
    protected Version $version;
    public Language $language;
    protected bool $archived;
    public VoucherStatus $voucherStatus;
    public string $voucherNumber;
    public DateTime $voucherDate;
    public Address $address;
    public TotalPrice $totalPrice;
    public TaxAmounts $taxAmounts;
    public TaxConditions $taxConditions;
    public RelatedVouchers $relatedVouchers;
    public PrintLayoutID $printLayoutId;
    public string $title;
    public string $introduction;
    public string $remark;
    public Files $files;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
