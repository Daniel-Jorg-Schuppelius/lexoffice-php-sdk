<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplate;
use Lexoffice\Entities\ID;

class RecurringTemplatesEndpoint extends BaseEndpointAbstract {
    protected string $endpoint = 'recurring-templates';

    public function get(?ID $id = null): RecurringTemplate {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return RecurringTemplate::fromJson($body);
    }
}
