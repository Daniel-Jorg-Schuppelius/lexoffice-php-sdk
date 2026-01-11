<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : RecurringTemplatesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints\Documents;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplate;
use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplatesPage;

class RecurringTemplatesEndpoint extends EndpointAbstract implements SearchableEndpointInterface {
    protected string $endpoint = 'recurring-templates';

    public function get(?ID $id = null): RecurringTemplate {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting a recurring template');
        }

        self::logDebug('Fetching recurring template', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn() => RecurringTemplate::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}")),
            "Recurring template fetched (ID: {$id->toString()})"
        );
    }

    public function search(array $queryParams = [], array $options = []): RecurringTemplatesPage {
        self::logDebug('Searching recurring templates', ['queryParams' => $queryParams]);

        return self::logDebugWithTimer(
            fn() => RecurringTemplatesPage::fromJson(parent::getContents($queryParams, $options)),
            'Recurring templates search completed'
        );
    }
}
