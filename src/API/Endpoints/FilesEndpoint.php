<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Files\File;
use Lexoffice\Entities\Files\FileResource;
use Lexoffice\Entities\ID;

class FilesEndpoint extends BaseEndpointAbstract {
    protected string $endpoint = 'files';

    public function upload(NamedEntityInterface $data, ID $id = null): FileResource {
        $response = $this->client->post($this->endpoint, [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return FileResource::fromJson($body);
    }

    public function get(ID $id): File {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return File::fromJson($body);
    }
}
