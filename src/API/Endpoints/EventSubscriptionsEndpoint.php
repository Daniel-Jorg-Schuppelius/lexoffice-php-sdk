<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : EventSubscriptionsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ClassicEndpointInterface;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\EventSubscriptions\EventSubscription;
use Lexoffice\Entities\EventSubscriptions\EventSubscriptionResource;
use Lexoffice\Entities\EventSubscriptions\EventSubscriptions;
use APIToolkit\Entities\ID;

class EventSubscriptionsEndpoint extends EndpointAbstract implements ClassicEndpointInterface, ListableEndpointInterface {
    protected string $endpoint = 'event-subscriptions';

    public function create(NamedEntityInterface $data, ID $id = null): EventSubscriptionResource {
        $response = $this->client->post($this->getEndpointUrl(), [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return EventSubscriptionResource::fromJson($body);
    }

    public function get(?ID $id = null): EventSubscription {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return EventSubscription::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}"));
    }

    public function update(ID $id, NamedEntityInterface $data): EventSubscriptionResource {
        $response = $this->client->put("{$this->getEndpointUrl()}/{$id->toString()}", [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 200);

        return EventSubscriptionResource::fromJson($body);
    }

    public function delete(ID $id): bool {
        $response = $this->client->delete("{$this->getEndpointUrl()}/{$id->toString()}");
        $this->handleResponse($response, 204);

        return true;
    }

    public function list(array $options = []): EventSubscriptions {
        return EventSubscriptions::fromJson(parent::getContents([], $options));
    }
}
