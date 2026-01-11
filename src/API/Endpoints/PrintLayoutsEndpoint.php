<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PrintLayoutsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PrintLayouts\PrintLayout;
use Lexoffice\Entities\PrintLayouts\PrintLayouts;

class PrintLayoutsEndpoint extends EndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'print-layouts';

    public function get(?ID $id = null): PrintLayout {
        self::logErrorAndThrow(NotAllowedException::class, 'Getting a single print layout is not allowed', [], null, 405);
    }

    public function list(array $options = []): PrintLayouts {
        self::logDebug('Listing print layouts');

        return self::logDebugWithTimer(
            fn() => PrintLayouts::fromJson(parent::getContents([], $options)),
            'Print layouts list fetched'
        );
    }
}
