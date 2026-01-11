<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ArticlesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\Contracts\Interfaces\API\ClassicEndpointInterface;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Entities\Articles\Article;
use Lexoffice\Entities\Articles\ArticleResource;
use Lexoffice\Entities\Articles\ArticlesPage;

class ArticlesEndpoint extends EndpointAbstract implements ClassicEndpointInterface, SearchableEndpointInterface {
    protected string $endpoint = 'articles';

    public function create(NamedEntityInterface $data, ?ID $id = null): ArticleResource {
        self::logDebug('Creating article', ['endpoint' => $this->endpoint]);

        return self::logInfoWithTimer(function () use ($data) {
            $response = $this->client->post($this->getEndpointUrl(), [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 201);

            return ArticleResource::fromJson($body);
        }, 'Article created');
    }

    public function get(?ID $id = null): Article {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting an article');
        }

        self::logDebug('Fetching article', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn() => Article::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}")),
            "Article fetched (ID: {$id->toString()})"
        );
    }

    public function update(ID $id, NamedEntityInterface $data): ArticleResource {
        self::logDebug('Updating article', ['id' => $id->toString()]);

        return self::logInfoWithTimer(function () use ($id, $data) {
            $response = $this->client->put("{$this->getEndpointUrl()}/{$id->toString()}", [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 200);

            return ArticleResource::fromJson($body);
        }, "Article updated (ID: {$id->toString()})");
    }

    public function delete(ID $id): bool {
        self::logDebug('Deleting article', ['id' => $id->toString()]);

        return self::logInfoWithTimer(function () use ($id) {
            $response = $this->client->delete("{$this->getEndpointUrl()}/{$id->toString()}");
            $this->handleResponse($response, 204);

            return true;
        }, "Article deleted (ID: {$id->toString()})");
    }

    public function search(array $queryParams = [], array $options = []): ArticlesPage {
        self::logDebug('Searching articles', ['queryParams' => $queryParams]);

        return self::logDebugWithTimer(
            fn() => ArticlesPage::fromJson(parent::getContents($queryParams, $options)),
            'Articles search completed'
        );
    }
}
