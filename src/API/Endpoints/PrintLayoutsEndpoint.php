<?php

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PrintLayouts\PrintLayout;
use APIToolkit\Entities\ID;
use Lexoffice\Entities\PrintLayouts\PrintLayouts;
use Lexoffice\Exceptions\NotAllowedException;

class PrintLayoutsEndpoint extends EndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'print-layouts';

    public function get(?ID $id = null): PrintLayout {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function list(array $options = []): PrintLayouts {
        return PrintLayouts::fromJson(parent::getContents([], $options));
    }
}
