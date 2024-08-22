<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Lexoffice\Entities\Contacts\ContactID;
use Lexoffice\Enums\VoucherStatus;
use Psr\Log\LoggerInterface;

class BaseVoucher extends NamedEntity implements IdentifiableInterface {
    protected ?VoucherID $id;
    public ?VoucherStatus $voucherStatus;
    public ?string $voucherNumber;
    public ?DateTime $voucherDate;
    public ?DateTime $dueDate;
    public ?string $contactName;
    public ?ContactID $contactId;
    protected ?DateTime $createdDate;
    protected ?DateTime $updatedDate;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): VoucherID {
        return $this->id;
    }
}
