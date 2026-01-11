<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : EventSubscriptionsEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\EventSubscriptionsEndpoint;
use Lexoffice\Entities\EventSubscriptions\EventSubscription;
use Lexoffice\Entities\EventSubscriptions\EventSubscriptionResource;
use Lexoffice\Entities\EventSubscriptions\EventSubscriptions;
use Tests\Contracts\OfflineEndpointTest;

class EventSubscriptionsEndpointOfflineTest extends OfflineEndpointTest {
    private EventSubscriptionsEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new EventSubscriptionsEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('POST', 'event-subscriptions', 201, json_encode([
            'subscriptionId' => 'sub-12345-67890',
            'resourceUri' => 'https://api.lexoffice.io/v1/event-subscriptions/sub-12345-67890',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'eventType' => 'contact.changed',
            'callbackUrl' => 'https://example.com/webhook',
        ]));

        $this->mockClient->addResponse('GET', 'event-subscriptions/sub-12345-67890', 200, json_encode([
            'subscriptionId' => 'sub-12345-67890',
            'organizationId' => 'org-12345',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'eventType' => 'contact.changed',
            'callbackUrl' => 'https://example.com/webhook',
        ]));

        $this->mockClient->addResponse('GET', 'event-subscriptions', 200, json_encode([
            'content' => [
                [
                    'subscriptionId' => 'sub-12345-67890',
                    'organizationId' => 'org-12345',
                    'createdDate' => '2024-03-15T10:30:00.000+01:00',
                    'eventType' => 'contact.changed',
                    'callbackUrl' => 'https://example.com/webhook',
                ],
            ],
        ]));
    }

    public function testCreateEventSubscription(): void {
        $data = [
            'eventType' => 'contact.changed',
            'callbackUrl' => 'https://example.com/webhook',
        ];

        $subscription = new EventSubscription($data);
        $result = $this->endpoint->create($subscription);

        $this->assertInstanceOf(EventSubscriptionResource::class, $result);
        $this->assertRequestMade('POST', 'event-subscriptions');
    }

    public function testGetEventSubscription(): void {
        $id = new ID('sub-12345-67890');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(EventSubscription::class, $result);
        $this->assertEquals('contact.changed', $result->getEventType()->value);
        $this->assertRequestMade('GET', 'event-subscriptions/sub-12345-67890');
    }

    public function testGetEventSubscriptionWithoutIdThrowsException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }

    public function testDeleteEventSubscription(): void {
        $this->mockClient->addResponse('DELETE', 'event-subscriptions/sub-12345-67890', 204, '');

        $id = new ID('sub-12345-67890');
        $result = $this->endpoint->delete($id);

        $this->assertTrue($result);
        $this->assertRequestMade('DELETE', 'event-subscriptions/sub-12345-67890');
    }

    public function testListEventSubscriptions(): void {
        $result = $this->endpoint->list();

        $this->assertInstanceOf(EventSubscriptions::class, $result);
        $this->assertRequestMade('GET', 'event-subscriptions');
    }
}
