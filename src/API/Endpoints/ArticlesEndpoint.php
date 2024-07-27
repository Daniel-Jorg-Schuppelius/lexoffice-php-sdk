<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\SearchableEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Articles\Article;
use Lexoffice\Entities\Articles\ArticleResource;
use Lexoffice\Entities\Articles\ArticlesPage;

class ArticlesEndpoint extends SearchableEndpointAbstract {
    protected string $endpoint = 'articles';

    public function create(array $data): ArticleResource {
        $response = $this->client->post($this->endpoint, [
            'json' => $data,
        ]);
        $body = $this->handleResponse($response, 201);

        return ArticleResource::fromArray($body);
    }

    public function get(string $id): Article {
        $response = $this->client->get("{$this->endpoint}/{$id}");
        $body = $this->handleResponse($response, 200);

        return Article::fromArray($body);
    }

    public function update(string $id, array $data): Article {
        $response = $this->client->put("{$this->endpoint}/{$id}", [
            'json' => $data,
        ]);
        $body = $this->handleResponse($response, 200);

        return Article::fromArray($body);
    }

    public function delete(string $id): bool {
        $response = $this->client->delete("{$this->endpoint}/{$id}");
        $this->handleResponse($response, 204);

        return true;
    }

    public function search(array $queryParams = []): NamedEntityInterface {
        $response = $this->client->get($this->endpoint, $queryParams);
        $body = $this->handleResponse($response, 200);

        return ArticlesPage::fromArray($body);
    }
}
