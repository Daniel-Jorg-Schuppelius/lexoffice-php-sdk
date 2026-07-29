<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Client.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API;

use APIToolkit\API\Authentication\BearerAuthentication;
use APIToolkit\Contracts\Abstracts\API\ClientAbstract;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * API-Client für die Lexoffice-REST-API (https://developers.lexoffice.io).
 *
 * Die Version steckt im Pfad (/v1). Da Guzzle relative Referenzen nach
 * RFC 3986 auflöst und dabei das letzte Segment einer pfadbehafteten base_uri
 * ersetzt, baut der Client die Ziel-URL selbst: Endpoints verwenden
 * API-relative Pfade (z. B. "contacts/{id}"), daraus wird baseUrl + /v1 + Pfad.
 * Absolute URLs (etwa resourceUri aus einer Antwort) passieren unverändert.
 */
class Client extends ClientAbstract {
    public const DEFAULT_BASE_URL = 'https://api.lexoffice.io';

    public const BASE_PATH = '/v1';

    public const MIN_INTERVAL = 0.5;

    protected float $requestInterval = 0.65;

    /**
     * @param HttpClient|null $httpClient Vorkonfigurierter Guzzle-Client — Naht
     *                                    für Tests (MockHandler) und für
     *                                    Anwendungen mit eigenem Transport.
     */
    public function __construct(
        #[\SensitiveParameter] ?string $apiKey,
        string $baseUrl = self::DEFAULT_BASE_URL,
        ?LoggerInterface $logger = null,
        bool $sleepAfterRequest = false,
        ?HttpClient $httpClient = null
    ) {
        parent::__construct(self::stripBasePath($baseUrl), $logger, $sleepAfterRequest, $httpClient);

        // Kein Default-Content-Type: Multipart-Uploads setzen ihren eigenen
        // (Guzzle ergänzt den Boundary nur, wenn der Header noch fehlt);
        // JSON-Requests nutzen die Guzzle-json-Option.
        $this->setDefaultHeaders([
            'Accept' => 'application/json',
        ]);

        if ($apiKey !== null) {
            $this->setAuthentication(new BearerAuthentication($apiKey));
        }
    }

    /**
     * Bis einschließlich v1.1.1 trug die baseUrl den Versionspfad selbst
     * ("https://api.lexoffice.io/v1/"). Solche Werte werden weiter akzeptiert,
     * der Pfad wird abgeschnitten und über prefixUri() wieder ergänzt.
     */
    protected static function stripBasePath(string $baseUrl): string {
        $trimmed = rtrim($baseUrl, '/');

        if (str_ends_with($trimmed, self::BASE_PATH)) {
            return substr($trimmed, 0, -strlen(self::BASE_PATH));
        }

        return $trimmed;
    }

    /**
     * Baut aus einem API-relativen URI die vollständige Ziel-URL
     * (baseUrl + /v1 + Pfad). Absolute URLs bleiben unverändert; ein
     * gerooteter Pfad ("/...") trägt den Basispfad selbst.
     */
    protected function prefixUri(string $uri): string {
        if ($uri === '' || str_starts_with($uri, 'http://') || str_starts_with($uri, 'https://')) {
            return $uri;
        }

        if (str_starts_with($uri, '/')) {
            return $this->getBaseUrl() . $uri;
        }

        return $this->getBaseUrl() . self::BASE_PATH . '/' . $uri;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function get(string $uri, array $options = []): ResponseInterface {
        return parent::get($this->prefixUri($uri), $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function post(string $uri, array $options = []): ResponseInterface {
        return parent::post($this->prefixUri($uri), $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function put(string $uri, array $options = []): ResponseInterface {
        return parent::put($this->prefixUri($uri), $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function patch(string $uri, array $options = []): ResponseInterface {
        return parent::patch($this->prefixUri($uri), $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function delete(string $uri, array $options = []): ResponseInterface {
        return parent::delete($this->prefixUri($uri), $options);
    }
}
