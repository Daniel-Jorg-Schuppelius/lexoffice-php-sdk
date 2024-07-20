<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\API;

use Psr\Http\Message\ResponseInterface;

interface ApiClientInterface {
    public function get(string $uri, array $options = []): ResponseInterface;
    public function post(string $uri, array $options = []): ResponseInterface;
    public function put(string $uri, array $options = []): ResponseInterface;
    public function delete(string $uri, array $options = []): ResponseInterface;
}
