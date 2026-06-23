<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ProfileEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use Lexoffice\API\Endpoints\ProfileEndpoint;
use Lexoffice\Entities\Profile\Profile;
use Tests\Contracts\OfflineEndpointTest;

class ProfileEndpointOfflineTest extends OfflineEndpointTest {
    private ProfileEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new ProfileEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('GET', 'profile', 200, json_encode([
            'organizationId' => 'org-12345-67890',
            'companyName' => 'Test Company GmbH',
            'created' => [
                'userId' => 'user-12345',
                'userName' => 'admin@testcompany.de',
                'userEmail' => 'admin@testcompany.de',
                'date' => '2024-01-01T10:00:00.000+01:00',
            ],
            'connectionId' => 'conn-12345',
            'features' => [],
            'subscriptionStatus' => 'active',
            'taxType' => 'net',
            'smallBusiness' => false,
        ]));
    }

    public function test_get_profile(): void {
        $result = $this->endpoint->get();

        $this->assertInstanceOf(Profile::class, $result);
        $this->assertEquals('org-12345-67890', $result->getOrganizationID()->toString());
        $this->assertEquals('Test Company GmbH', $result->getCompanyName());
        $this->assertRequestMade('GET', 'profile');
    }

    public function test_get_profile_with_id_ignores_id(): void {
        // Profile endpoint ignores the ID parameter
        $result = $this->endpoint->get(null);

        $this->assertInstanceOf(Profile::class, $result);
        $this->assertRequestMade('GET', 'profile');
    }
}
