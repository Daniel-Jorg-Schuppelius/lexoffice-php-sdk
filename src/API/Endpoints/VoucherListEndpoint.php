<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : VoucherListEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Entities\VoucherList\VoucherListPage;
use APIToolkit\Entities\ID;
use Lexoffice\Entities\VoucherList\Vouchers;

class VoucherListEndpoint extends EndpointAbstract implements SearchableEndpointInterface {
    protected string $endpoint = 'voucherlist';

    public function get(?ID $id = null): Vouchers {
        return $this->search(["voucherType" => "any", "voucherStatus" => "any"])->getContent();
    }

    public function search(array $queryParams = [], array $options = []): VoucherListPage {
        if (!isset($queryParams['voucherType'])) {
            throw new \InvalidArgumentException('voucherType is required in $queryParams');
        } else if (!isset($queryParams['voucherStatus'])) {
            throw new \InvalidArgumentException('voucherStatus is required in $queryParams');
        }

        return VoucherListPage::fromJson(parent::getContents($queryParams, $options));
    }
}
