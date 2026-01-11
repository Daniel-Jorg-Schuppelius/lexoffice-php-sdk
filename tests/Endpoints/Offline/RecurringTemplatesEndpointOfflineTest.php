<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : RecurringTemplatesEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\Documents\RecurringTemplatesEndpoint;
use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplate;
use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplatesPage;
use Tests\Contracts\OfflineEndpointTest;

class RecurringTemplatesEndpointOfflineTest extends OfflineEndpointTest {
    private RecurringTemplatesEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new RecurringTemplatesEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('GET', 'recurring-templates/7b6ce389-8ebb-4492-9a2a-6aa1320b5fca', 200, json_encode([
            'id' => '7b6ce389-8ebb-4492-9a2a-6aa1320b5fca',
            'version' => 0,
            'title' => 'Monthly Invoice Template',
            'address' => [
                'name' => 'Test Customer',
            ],
            'lineItems' => [
                [
                    'type' => 'custom',
                    'name' => 'Monthly Service',
                    'quantity' => 1,
                    'unitPrice' => [
                        'netAmount' => 100.00,
                        'taxRatePercentage' => 19,
                    ],
                ],
            ],
            'totalPrice' => [
                'totalNetAmount' => 100.00,
                'totalGrossAmount' => 119.00,
                'totalTaxAmount' => 19.00,
                'currency' => 'EUR',
            ],
            'taxConditions' => [
                'taxType' => 'net',
            ],
            'recurringTemplateSettings' => [
                'executionInterval' => 'MONTHLY',
                'nextExecutionDate' => '2024-04-01',
                'executionStatus' => 'ACTIVE',
            ],
        ]));

        $this->mockClient->addResponse('GET', 'recurring-templates', 200, json_encode([
            'content' => [
                [
                    'id' => '7b6ce389-8ebb-4492-9a2a-6aa1320b5fca',
                    'version' => 0,
                    'title' => 'Monthly Invoice Template',
                ],
            ],
            'totalElements' => 1,
            'totalPages' => 1,
            'size' => 25,
            'number' => 0,
            'numberOfElements' => 1,
            'first' => true,
            'last' => true,
            'sort' => [
                [
                    'property' => 'nextExecutionDate',
                    'direction' => 'DESC',
                ],
            ],
        ]));

        $this->mockClient->setDefaultResponse(200, json_encode([
            'id' => '7b6ce389-8ebb-4492-9a2a-6aa1320b5fca',
            'version' => 0,
        ]));
    }

    public function testGetRecurringTemplate(): void {
        $id = new ID('7b6ce389-8ebb-4492-9a2a-6aa1320b5fca');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(RecurringTemplate::class, $result);
        $this->assertEquals('Monthly Invoice Template', $result->getTitle());
        $this->assertRequestMade('GET', 'recurring-templates/7b6ce389-8ebb-4492-9a2a-6aa1320b5fca');
    }

    public function testGetRecurringTemplateWithoutIdThrowsException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }

    public function testSearchRecurringTemplates(): void {
        $result = $this->endpoint->search();

        $this->assertInstanceOf(RecurringTemplatesPage::class, $result);
        $this->assertRequestMade('GET', 'recurring-templates');
    }
}
