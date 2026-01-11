<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : EventSubscriptionsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\Contracts\Interfaces\API\ClassicEndpointInterface;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\EventSubscriptions\EventSubscription;
use Lexoffice\Entities\EventSubscriptions\EventSubscriptionResource;
use Lexoffice\Entities\EventSubscriptions\EventSubscriptions;

class EventSubscriptionsEndpoint extends EndpointAbstract implements ClassicEndpointInterface, ListableEndpointInterface {
    protected string $endpoint = 'event-subscriptions';

    public function create(NamedEntityInterface $data, ?ID $id = null): EventSubscriptionResource {
        self::logDebug('Creating event subscription', ['endpoint' => $this->endpoint]);

        return self::logInfoWithTimer(function () use ($data) {
            $response = $this->client->post($this->getEndpointUrl(), [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 201);

            return EventSubscriptionResource::fromJson($body);
        }, 'Event subscription created');
    }

    public function get(?ID $id = null): EventSubscription {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting an event subscription');
        }

        self::logDebug('Fetching event subscription', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn() => EventSubscription::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}")),
            "Event subscription fetched (ID: {$id->toString()})"
        );
    }

    public function update(ID $id, NamedEntityInterface $data): EventSubscriptionResource {
        self::logDebug('Updating event subscription', ['id' => $id->toString()]);

        return self::logInfoWithTimer(function () use ($id, $data) {
            $response = $this->client->put("{$this->getEndpointUrl()}/{$id->toString()}", [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 200);

            return EventSubscriptionResource::fromJson($body);
        }, "Event subscription updated (ID: {$id->toString()})");
    }

    public function delete(ID $id): bool {
        self::logDebug('Deleting event subscription', ['id' => $id->toString()]);

        return self::logInfoWithTimer(function () use ($id) {
            $response = $this->client->delete("{$this->getEndpointUrl()}/{$id->toString()}");
            $this->handleResponse($response, 204);

            return true;
        }, "Event subscription deleted (ID: {$id->toString()})");
    }

    public function list(array $options = []): EventSubscriptions {
        self::logDebug('Listing event subscriptions');

        return self::logDebugWithTimer(
            fn() => EventSubscriptions::fromJson(parent::getContents([], $options)),
            'Event subscriptions list fetched'
        );
    }
}
