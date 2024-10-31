<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ArticlesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ClassicEndpointInterface;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Articles\Article;
use Lexoffice\Entities\Articles\ArticleResource;
use Lexoffice\Entities\Articles\ArticlesPage;
use APIToolkit\Entities\ID;

class ArticlesEndpoint extends EndpointAbstract implements ClassicEndpointInterface, SearchableEndpointInterface {
    protected string $endpoint = 'articles';

    public function create(NamedEntityInterface $data, ID $id = null): ArticleResource {
        $response = $this->client->post($this->getEndpointUrl(), [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return ArticleResource::fromJson($body);
    }

    public function get(?ID $id = null): Article {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return Article::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }

    public function update(ID $id, NamedEntityInterface $data): ArticleResource {
        $response = $this->client->put("{$this->getEndpointUrl()}/{$id->toString()}", [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 200);

        return ArticleResource::fromJson($body);
    }

    public function delete(ID $id): bool {
        $response = $this->client->delete("{$this->getEndpointUrl()}/{$id->toString()}");
        $this->handleResponse($response, 204);

        return true;
    }

    public function search(array $queryParams = [], array $options = []): ArticlesPage {
        return ArticlesPage::fromJson(parent::getContents($queryParams, $options));
    }
}
