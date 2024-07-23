<?php

declare(strict_types=1);

namespace Tests\Lexoffice\Entities;

use Lexoffice\Entities\EventSubscriptions\EventSubscriptions;
use PHPUnit\Framework\TestCase;

class EventSubscriptionsTest extends TestCase {
    public function testCreateEventSubscriptions() {
        $data = [
            "content" => [
                [
                    "subscriptionId" => "49aa2f76-c51a-4df3-ae83-3a103d781494",
                    "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
                    "createdDate" => "2023-04-11T12:20:00.000+02:00",
                    "eventType" => "contact.changed",
                    "callbackUrl" => "https://example.org/webhook"
                ],
                [
                    "subscriptionId" => "49aa2f76-c51a-4df3-ae83-3a103d781495",
                    "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd9",
                    "createdDate" => "2023-04-13T12:20:00.000+02:00",
                    "eventType" => "contact.created",
                    "callbackUrl" => "https://example.org/webhook1"
                ]
            ]
        ];

        $eventSubscriptions = new EventSubscriptions($data);
        $this->assertInstanceOf(EventSubscriptions::class, $eventSubscriptions);
    }
}
