<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Vouchers\Voucher;
use Lexoffice\Entities\Vouchers\VoucherResource;
use Lexoffice\Entities\Vouchers\VouchersPage;
use Lexoffice\Entities\ID;
use Lexoffice\Exceptions\NotAllowedException;

class VouchersEndpoint extends BaseEndpointAbstract implements SearchableEndpointInterface {
    protected string $endpoint = 'vouchers';

    public function create(NamedEntityInterface $data, ID $id = null): VoucherResource {
        $response = $this->client->post($this->endpoint, [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 200);

        return VoucherResource::fromJson($body);
    }

    public function get(?ID $id = null): Voucher {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return Voucher::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }

    public function update(ID $id, NamedEntityInterface $data): VoucherResource {
        $response = $this->client->put("{$this->endpoint}/{$id->toString()}", [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 200);

        return VoucherResource::fromJson($body);
    }

    public function delete(ID $id): bool {
        throw new NotAllowedException('Vouchers cannot be deleted');
    }

    public function search(array $queryParams = [], array $options = []): VouchersPage {
        if (!isset($queryParams['voucherNumber'])) {
            throw new \InvalidArgumentException('voucherNumber is required in $queryParams');
        }

        return VouchersPage::fromJson(parent::getContents($queryParams, $options));
    }
}