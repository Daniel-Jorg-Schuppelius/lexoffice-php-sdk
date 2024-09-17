<?php

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Entities\VoucherList\VoucherListPage;
use APIToolkit\Entities\ID;
use Lexoffice\Entities\VoucherList\Vouchers;

class VoucherlistEndpoint extends EndpointAbstract implements SearchableEndpointInterface {
    protected string $endpoint = 'voucherlist';

    public function get(?ID $id = null): Vouchers {
        return $this->search(["voucherType" => "any", "voucherStatus" => "any"])->getContent();
    }

    public function search(array $queryParams = [], array $options = []): VoucherlistPage {
        if (!isset($queryParams['voucherType'])) {
            throw new \InvalidArgumentException('voucherType is required in $queryParams');
        } else if (!isset($queryParams['voucherStatus'])) {
            throw new \InvalidArgumentException('voucherStatus is required in $queryParams');
        }

        return VoucherlistPage::fromJson(parent::getContents($queryParams, $options));
    }
}
