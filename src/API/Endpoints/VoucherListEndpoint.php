<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : VoucherListEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Entities\VoucherList\Vouchers;
use Lexoffice\Entities\VoucherList\VoucherListPage;

class VoucherListEndpoint extends EndpointAbstract implements SearchableEndpointInterface {
    protected string $endpoint = 'voucherlist';

    public function get(?ID $id = null): Vouchers {
        self::logDebug('Getting all vouchers');

        return $this->search(['voucherType' => 'any', 'voucherStatus' => 'any'])->getContent();
    }

    public function search(array $queryParams = [], array $options = []): VoucherListPage {
        if (!isset($queryParams['voucherType'])) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'voucherType is required in $queryParams');
        } elseif (!isset($queryParams['voucherStatus'])) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'voucherStatus is required in $queryParams');
        }

        self::logDebug('Searching voucher list', ['queryParams' => $queryParams]);

        return self::logDebugWithTimer(
            fn() => VoucherListPage::fromJson(parent::getContents($queryParams, $options)),
            'Voucher list search completed'
        );
    }
}
