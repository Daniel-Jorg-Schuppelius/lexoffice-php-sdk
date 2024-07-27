<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\Contacts\ContactID;
use Lexoffice\Entities\Files\Files;
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Enums\TaxType;
use Lexoffice\Enums\VoucherStatus;
use Lexoffice\Enums\VoucherType;

class Voucher extends NamedEntity {
    public VoucherID $id;
    public OrganizationID $organizationId;
    public VoucherType $type;
    public VoucherStatus $voucherStatus;
    public ?string $voucherNumber;
    public ?DateTime $voucherDate;
    public ?DateTime $shippingDate;
    public ?DateTime $dueDate;
    public float $totalGrossAmount;
    public float $totalTaxAmount;
    public TaxType $taxType;
    public bool $useCollectiveContact;
    public ?string $contactName;
    public ContactID $contactId;
    public string $remark;
    public VoucherItems $voucherItems;
    public Files $files;
    protected DateTime $createdDate;
    protected DateTime $updatedDate;
    protected int $version;


    public function __construct($data = null) {
        parent::__construct($data);
    }
}
