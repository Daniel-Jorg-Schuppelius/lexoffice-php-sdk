<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Voucher.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use DateTime;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableNamedEntityInterface;
use Lexoffice\Entities\Files\Files;
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Enums\TaxType;
use Lexoffice\Enums\VoucherType;

class Voucher extends BaseVoucher implements OrganizationIdentifiableNamedEntityInterface {
    protected ?OrganizationID $organizationId;
    protected VoucherType $type;
    protected ?DateTime $shippingDate;
    protected ?float $totalGrossAmount;
    protected ?float $totalTaxAmount;
    protected TaxType $taxType;
    protected ?bool $useCollectiveContact;
    protected ?string $remark;
    protected ?VoucherItems $voucherItems;
    protected ?Files $files;
    protected ?int $version;

    public function getOrganizationID(): OrganizationID {
        return $this->organizationId;
    }

    public function getType(): VoucherType {
        return $this->type;
    }

    public function getShippingDate(): ?DateTime {
        return $this->shippingDate;
    }

    public function getTotalGrossAmount(): ?float {
        return $this->totalGrossAmount;
    }

    public function getTotalTaxAmount(): ?float {
        return $this->totalTaxAmount;
    }

    public function getTaxType(): TaxType {
        return $this->taxType;
    }

    public function getUseCollectiveContact(): ?bool {
        return $this->useCollectiveContact;
    }

    public function getRemark(): ?string {
        return $this->remark;
    }

    public function getVoucherItems(): ?VoucherItems {
        return $this->voucherItems;
    }

    public function getFiles(): ?Files {
        return $this->files;
    }

    public function getVersion(): ?int {
        return $this->version;
    }

    public function setType(VoucherType $type): void {
        $this->type = $type;
    }

    public function setShippingDate(DateTime $shippingDate): void {
        $this->shippingDate = $shippingDate;
    }

    public function setTotalGrossAmount(float $totalGrossAmount): void {
        $this->totalGrossAmount = $totalGrossAmount;
    }

    public function setTotalTaxAmount(float $totalTaxAmount): void {
        $this->totalTaxAmount = $totalTaxAmount;
    }

    public function setTaxType(TaxType $taxType): void {
        $this->taxType = $taxType;
    }

    public function setUseCollectiveContact(bool $useCollectiveContact): void {
        $this->useCollectiveContact = $useCollectiveContact;
    }

    public function setRemark(string $remark): void {
        $this->remark = $remark;
    }

    public function setVoucherItems(VoucherItems $voucherItems): void {
        $this->voucherItems = $voucherItems;
    }

    public function setFiles(Files $files): void {
        $this->files = $files;
    }
}
