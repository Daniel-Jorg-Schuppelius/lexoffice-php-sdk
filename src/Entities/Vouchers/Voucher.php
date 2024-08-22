<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use DateTime;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableInterface;
use Lexoffice\Entities\Files\Files;
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Enums\TaxType;
use Lexoffice\Enums\VoucherType;

class Voucher extends BaseVoucher implements OrganizationIdentifiableInterface {
    protected ?OrganizationID $organizationId;
    public VoucherType $type;
    public ?DateTime $shippingDate;
    public ?float $totalGrossAmount;
    public ?float $totalTaxAmount;
    public TaxType $taxType;
    public ?bool $useCollectiveContact;
    public ?string $remark;
    public ?VoucherItems $voucherItems;
    public ?Files $files;
    protected ?int $version;

    public function getOrganizationID(): OrganizationID {
        return $this->organizationId;
    }
}
