<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : EventSubscriptionsEndpointTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Tests\Endpoints;

use Lexoffice\API\Endpoints\EventSubscriptionsEndpoint;
use Lexoffice\Entities\EventSubscriptions\{EventSubscription, EventSubscriptionResource};
use Tests\Contracts\EndpointTest;

class EventSubscriptionsEndpointTest extends EndpointTest {
    protected EventSubscriptionsEndpoint $endpoint;

    protected function setUp(): void {
        $this->apiDisabled = true; // API is disabled
        parent::setUp();
        $this->endpoint = new EventSubscriptionsEndpoint($this->client);
    }

    public function test_json_serialize(): void {
        $data = [
            "eventType" => "contact.changed",
            "callbackUrl" => "https://schuppelius.org/webhook",
        ];

        $eventSubscription = new EventSubscription($data);
        $this->assertEquals($data, $eventSubscription->toArray());
        $this->assertEquals(json_encode($data), $eventSubscription->toJson());  // the order of the $data array is important for this test.
    }

    public function test_create_and_delete_event_subscription_api(): void {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "eventType" => "contact.changed",
            "callbackUrl" => "https://schuppelius.org/webhook1",
        ];

        $eventSubscription = new EventSubscription($data);
        $eventSubscriptionResource = $this->endpoint->create($eventSubscription);
        $this->assertInstanceOf(EventSubscriptionResource::class, $eventSubscriptionResource);
        $this->endpoint->delete($eventSubscriptionResource->getId());
    }

    public function test_create_get_update_and_delete_event_subscription_api(): void {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "eventType" => "contact.created",
            "callbackUrl" => "https://schuppelius.org/webhook2",
        ];

        $eventSubscriptionResource = $this->endpoint->create(new EventSubscription($data));
        $this->assertInstanceOf(EventSubscriptionResource::class, $eventSubscriptionResource);
        $eventSubscription = $this->endpoint->get($eventSubscriptionResource->getId());
        $this->assertEquals($data['eventType'], $eventSubscription->getEventType()->value);
        $this->assertEquals($data['callbackUrl'], $eventSubscription->getCallbackUrl());
        $this->endpoint->delete($eventSubscriptionResource->getId());
    }

    public function test_list_and_delete_event_subscriptions_api(): void {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "eventType" => "article.created",
            "callbackUrl" => "https://schuppelius.org/webhook3",
        ];

        $data1 = [
            "eventType" => "article.deleted",
            "callbackUrl" => "https://schuppelius.org/webhook4",
        ];

        $this->endpoint->create(new EventSubscription($data));
        $this->endpoint->create(new EventSubscription($data1));

        $eventSubscriptions = $this->endpoint->list();
        foreach ($eventSubscriptions->getValues() as $val) {
            $id = $val->getId();
            $this->assertNotNull($id);
            $this->endpoint->delete($id);
        }
        $eventSubscriptions = $this->endpoint->list();
        $this->assertEquals(0, count($eventSubscriptions->getValues()));
    }
}
