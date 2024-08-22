<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\SearchableEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Vouchers\Voucher;
use Lexoffice\Entities\Vouchers\VoucherResource;
use Lexoffice\Entities\Vouchers\VouchersPage;
use Lexoffice\Entities\ID;
use Lexoffice\Exceptions\NotAllowedException;

class VouchersEndpoint extends SearchableEndpointAbstract {
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

        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return Voucher::fromJson($body);
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

        $params = "?" . http_build_query($queryParams) ?? '';
        $response = $this->client->get($this->endpoint . $params, $options);

        $body = $this->handleResponse($response, 200);

        return VouchersPage::fromJson($body);
    }
}
