<?php

declare(strict_types=1);

namespace Lexoffice\Entities\VoucherList;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Entities\Contacts\ContactID;
use Lexoffice\Entities\Vouchers\VoucherID;
use Lexoffice\Enums\Currency;
use Lexoffice\Enums\VoucherStatus;
use Lexoffice\Enums\VoucherType;

class Voucher extends NamedEntity {
    protected VoucherID $id;
    protected VoucherType $voucherType;
    protected VoucherStatus $voucherStatus;
    protected ?string $voucherNumber;
    protected ?DateTime $voucherDate;
    protected DateTime $createdDate;
    protected DateTime $updatedDate;
    protected ?DateTime $dueDate;
    protected ?ContactID $contactId;
    protected ?string $contactName;
    protected float $totalAmount;
    protected float $openAmount;
    protected Currency $currency;
    public bool $archived;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
