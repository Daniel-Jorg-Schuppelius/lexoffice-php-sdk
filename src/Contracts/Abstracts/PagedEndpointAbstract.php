<?php
/*
 * Created on   : Wed Jul 29 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PagedEndpointAbstract.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use APIToolkit\Contracts\Abstracts\API\PagedEndpointAbstract as APIToolkitPagedEndpointAbstract;

/**
 * Basis für Endpoints mit seitenweiser Suche.
 *
 * Lexoffice adressiert Seiten nullbasiert über page/size und erlaubt maximal
 * 250 Einträge je Seite; searchAll() kommt aus dem api-toolkit.
 */
abstract class PagedEndpointAbstract extends APIToolkitPagedEndpointAbstract {
    public const MAX_PAGE_SIZE = 250;

    /**
     * @param array<string, mixed> $queryParams
     * @param array<string, mixed> $options
     */
    abstract public function search(array $queryParams = [], array $options = []): NamedPage;

    /**
     * @return array<string, mixed>
     */
    protected function pageQueryParams(int $page, int $pageSize): array {
        return ['page' => $page, 'size' => $pageSize];
    }

    /**
     * @param array<string, mixed> $queryParams
     * @param array<string, mixed> $options
     * @return array<int, mixed>
     */
    protected function pageItems(array $queryParams, array $options): array {
        return $this->search($queryParams, $options)->getValues();
    }
}
