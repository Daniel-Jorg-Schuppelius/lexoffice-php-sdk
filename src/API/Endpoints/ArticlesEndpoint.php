<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\SearchableEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Articles\Article;
use Lexoffice\Entities\Articles\ArticleResource;
use Lexoffice\Entities\Articles\ArticlesPage;
use Lexoffice\Entities\ID;

class ArticlesEndpoint extends SearchableEndpointAbstract {
    protected string $endpoint = 'articles';

    public function create(NamedEntityInterface $data, ID $id = null): ArticleResource {
        $response = $this->client->post($this->endpoint, [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return ArticleResource::fromJson($body);
    }

    public function get(?ID $id = null): Article {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return Article::fromJson($body);
    }

    public function update(ID $id, NamedEntityInterface $data): ArticleResource {
        $response = $this->client->put("{$this->endpoint}/{$id->toString()}", [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 200);

        return ArticleResource::fromJson($body);
    }

    public function delete(ID $id): bool {
        $response = $this->client->delete("{$this->endpoint}/{$id->toString()}");
        $this->handleResponse($response, 204);

        return true;
    }

    public function search(array $queryParams = [], array $options = []): ArticlesPage {
        $params = "?" . http_build_query($queryParams) ?? '';
        $response = $this->client->get($this->endpoint . $params, $options);
        $body = $this->handleResponse($response, 200);

        return ArticlesPage::fromJson($body);
    }
}
