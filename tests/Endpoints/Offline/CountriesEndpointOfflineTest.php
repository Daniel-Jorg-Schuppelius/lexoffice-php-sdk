<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : CountriesEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Exceptions\NotAllowedException;
use Lexoffice\API\Endpoints\CountriesEndpoint;
use Lexoffice\Entities\Countries\Countries;
use Tests\Contracts\OfflineEndpointTest;

class CountriesEndpointOfflineTest extends OfflineEndpointTest {
    private CountriesEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new CountriesEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('GET', 'countries', 200, json_encode([
            [
                'countryCode' => 'DE',
                'countryNameDE' => 'Deutschland',
                'countryNameEN' => 'Germany',
                'taxClassification' => 'intraCommunity',
            ],
            [
                'countryCode' => 'AT',
                'countryNameDE' => 'Österreich',
                'countryNameEN' => 'Austria',
                'taxClassification' => 'intraCommunity',
            ],
            [
                'countryCode' => 'CH',
                'countryNameDE' => 'Schweiz',
                'countryNameEN' => 'Switzerland',
                'taxClassification' => 'thirdPartyCountry',
            ],
        ]));
    }

    public function test_list_countries(): void {
        $result = $this->endpoint->list();

        $this->assertInstanceOf(Countries::class, $result);
        $this->assertRequestMade('GET', 'countries');
    }

    public function test_get_country_throws_not_allowed_exception(): void {
        $this->expectException(NotAllowedException::class);
        $this->expectExceptionMessage('Getting a single country is not allowed');

        $this->endpoint->get(null);
    }
}
