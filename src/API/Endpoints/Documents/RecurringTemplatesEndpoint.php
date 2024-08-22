<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplate;
use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplatesPage;
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

    public function getAll(array $queryParams = [], array $options = []): RecurringTemplatesPage {
        $params = "?" . http_build_query($queryParams) ?? '';
        $response = $this->client->get($this->endpoint . $params, $options);
        $body = $this->handleResponse($response, 200);

        return RecurringTemplatesPage::fromJson($body);
    }
}
