<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\ClassicEndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\EventSubscriptions\EventSubscription;
use Lexoffice\Entities\EventSubscriptions\EventSubscriptionResource;
use Lexoffice\Entities\EventSubscriptions\EventSubscriptions;
use Lexoffice\Entities\ID;

class EventSubscriptionsEndpoint extends ClassicEndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'event-subscriptions';

    public function create(NamedEntityInterface $data, ID $id = null): EventSubscriptionResource {
        $response = $this->client->post($this->endpoint, [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return EventSubscriptionResource::fromJson($body);
    }

    public function get(?ID $id = null): EventSubscription {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return EventSubscription::fromJson($body);
    }

    public function update(ID $id, NamedEntityInterface $data): EventSubscriptionResource {
        $response = $this->client->put("{$this->endpoint}/{$id->toString()}", [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 200);

        return EventSubscriptionResource::fromJson($body);
    }

    public function delete(ID $id): bool {
        $response = $this->client->delete("{$this->endpoint}/{$id->toString()}");
        $this->handleResponse($response, 204);

        return true;
    }

    public function list(array $queryParams = []): EventSubscriptions {
        $response = $this->client->get("{$this->endpoint}", $queryParams);
        $body = $this->handleResponse($response, 200);

        return EventSubscriptions::fromJson($body);
    }
}
