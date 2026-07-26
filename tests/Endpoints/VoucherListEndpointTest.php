<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : VoucherListEndpointTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Tests\Endpoints;

use APIToolkit\Contracts\Interfaces\API\EndpointInterface;
use Lexoffice\API\Endpoints\VoucherListEndpoint;
use Lexoffice\Entities\VoucherList\Vouchers;
use Tests\Contracts\EndpointTest;

class VoucherListEndpointTest extends EndpointTest {
    private EndpointInterface $endpoint;

    protected function setUp(): void {
        $this->apiDisabled = true; // API is disabled
        parent::setUp();
        $this->endpoint = new VoucherListEndpoint($this->client);
    }
    public function test_get_voucher_list_api(): void {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $voucherList = $this->endpoint->get();
        $this->assertInstanceOf(Vouchers::class, $voucherList);
    }
}
