<?php

namespace Tests\Endpoints;

use Lexoffice\API\Endpoints\EventSubscriptionsEndpoint;
use Lexoffice\Entities\EventSubscriptions\EventSubscription;
use Lexoffice\Entities\EventSubscriptions\EventSubscriptionResource;
use Tests\Contracts\EndpointTest;

class EventSubscriptionsEndpointTest extends EndpointTest {
    protected ?EventSubscriptionsEndpoint $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new EventSubscriptionsEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }

    public function testJsonSerialize() {
        $data = [
            "eventType" => "contact.changed",
            "callbackUrl" => "https://schuppelius.org/webhook"
        ];

        $eventSubscription = new EventSubscription($data);
        $this->assertEquals($data, $eventSubscription->toArray());
        $this->assertEquals(json_encode($data), $eventSubscription->toJson());  // the order of the $data array is important for this test.
    }

    public function testCreateAndDeleteEventSubscriptionAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "eventType" => "contact.changed",
            "callbackUrl" => "https://schuppelius.org/webhook1"
        ];

        $eventSubscription = new EventSubscription($data);
        $eventSubscriptionResource = $this->endpoint->create($eventSubscription);
        $this->assertInstanceOf(EventSubscriptionResource::class, $eventSubscriptionResource);
        $this->endpoint->delete($eventSubscriptionResource->getId());
    }

    public function testCreateGetUpdateAndDeleteEventSubscriptionAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "eventType" => "contact.created",
            "callbackUrl" => "https://schuppelius.org/webhook2"
        ];

        $eventSubscriptionResource = $this->endpoint->create(new EventSubscription($data));
        $this->assertInstanceOf(EventSubscriptionResource::class, $eventSubscriptionResource);
        $eventSubscription = $this->endpoint->get($eventSubscriptionResource->getId());
        $this->assertEquals($data['eventType'], $eventSubscription->getEventType()->value);
        $this->assertEquals($data['callbackUrl'], $eventSubscription->getCallbackUrl());
        $this->endpoint->delete($eventSubscriptionResource->getId());
    }

    public function testListAndDeleteEventSubscriptionsAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "eventType" => "article.created",
            "callbackUrl" => "https://schuppelius.org/webhook3"
        ];

        $data1 = [
            "eventType" => "article.deleted",
            "callbackUrl" => "https://schuppelius.org/webhook4"
        ];

        $this->endpoint->create(new EventSubscription($data));
        $this->endpoint->create(new EventSubscription($data1));

        $eventSubscriptions = $this->endpoint->list();
        foreach ($eventSubscriptions->getValues() as $val) {
            $this->endpoint->delete($val->getId());
        }
        $eventSubscriptions = $this->endpoint->list();
        $this->assertEquals(0, count($eventSubscriptions->getValues()));
    }
}