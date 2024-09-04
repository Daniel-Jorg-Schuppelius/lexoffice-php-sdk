<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Psr\Log\LoggerInterface;

class PhoneNumbers extends NamedEntity {
    protected ?PhoneNumberList $business;
    protected ?PhoneNumberList $office;
    protected ?PhoneNumberList $mobile;
    protected ?PhoneNumberList $private;
    protected ?PhoneNumberList $fax;
    protected ?PhoneNumberList $other;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getBusiness(): ?PhoneNumberList {
        return $this->business ?? null;
    }

    public function getOffice(): ?PhoneNumberList {
        return $this->office ?? null;
    }

    public function getMobile(): ?PhoneNumberList {
        return $this->mobile ?? null;
    }

    public function getPrivate(): ?PhoneNumberList {
        return $this->private ?? null;
    }

    public function getFax(): ?PhoneNumberList {
        return $this->fax ?? null;
    }

    public function getOther(): ?PhoneNumberList {
        return $this->other ?? null;
    }

    public function setBusiness(?PhoneNumberList $business): void {
        $this->business = $business;
    }

    public function setOffice(?PhoneNumberList $office): void {
        $this->office = $office;
    }

    public function setMobile(?PhoneNumberList $mobile): void {
        $this->mobile = $mobile;
    }

    public function setPrivate(?PhoneNumberList $private): void {
        $this->private = $private;
    }

    public function setFax(?PhoneNumberList $fax): void {
        $this->fax = $fax;
    }

    public function setOther(?PhoneNumberList $other): void {
        $this->other = $other;
    }
}