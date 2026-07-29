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

use APIToolkit\API\Pagination\OffsetPaginator;
use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Generator;

/**
 * Basis für Endpoints mit seitenweiser Suche (page/size).
 *
 * Lexoffice liefert Treffer in nullbasierten Seiten. searchAll() läuft sie über
 * den {@see OffsetPaginator} des api-toolkits durch und gibt die einzelnen
 * Einträge aus — Aufrufer müssen weder Seitenzähler noch Abbruchbedingung
 * selbst führen.
 */
abstract class PagedEndpointAbstract extends EndpointAbstract {
    /** Lexoffice erlaubt maximal 250 Einträge je Seite. */
    public const MAX_PAGE_SIZE = 250;

    public const DEFAULT_PAGE_SIZE = 100;

    /**
     * @param array<string, mixed> $queryParams
     * @param array<string, mixed> $options
     */
    abstract public function search(array $queryParams = [], array $options = []): NamedPage;

    /**
     * Iteriert alle Treffer einer Suche über sämtliche Seiten hinweg.
     *
     * @param array<string, mixed> $queryParams Suchparameter ohne page/size
     * @param array<string, mixed> $options
     * @param int|null $maxPages Obergrenze für die Zahl geladener Seiten
     * @return Generator<int, mixed>
     */
    public function searchAll(array $queryParams = [], int $pageSize = self::DEFAULT_PAGE_SIZE, array $options = [], ?int $maxPages = null): Generator {
        $pageSize = max(1, min($pageSize, self::MAX_PAGE_SIZE));

        $paginator = new OffsetPaginator(
            fn (int $page): array => $this->search(
                array_merge($queryParams, ['page' => $page, 'size' => $pageSize]),
                $options
            )->getValues(),
            $pageSize,
            0,
            $maxPages
        );

        yield from $paginator;
    }
}
