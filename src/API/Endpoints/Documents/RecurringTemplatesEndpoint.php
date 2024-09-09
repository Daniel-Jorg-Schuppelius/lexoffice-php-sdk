<?php

namespace Lexoffice\Api\Endpoints\Documents;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplate;
use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplatesPage;
use APIToolkit\Entities\ID;

class RecurringTemplatesEndpoint extends EndpointAbstract implements SearchableEndpointInterface {
    protected string $endpoint = 'recurring-templates';

    public function get(?ID $id = null): RecurringTemplate {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return RecurringTemplate::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }

    public function search(array $queryParams = [], array $options = []): RecurringTemplatesPage {
        return RecurringTemplatesPage::fromJson(parent::getContents($queryParams, $options));
    }
}
