<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Entities\VoucherList\VoucherListPage;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\VoucherList\Vouchers;

class VoucherlistEndpoint extends BaseEndpointAbstract implements SearchableEndpointInterface {
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

        $params = "?" . http_build_query($queryParams) ?? '';
        $response = $this->client->get($this->endpoint . $params, $options);
        $this->handleResponse($response, 200);

        return VoucherListPage::fromJson($response->getBody());
    }
}
