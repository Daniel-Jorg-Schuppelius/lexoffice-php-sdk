<?php

namespace Tests;

use Lexoffice\API\Client;
use Lexoffice\Contracts\Interfaces\API\ApiClientInterface;
use Lexoffice\Logger\ConsoleLoggerFactory;
use Tests\Config\PostmanConfig;

class TestAPIClientFactory {
    private static ?ApiClientInterface $client = null;

    public static function getClient(): ApiClientInterface {
        if (self::$client === null) {
            $config = new PostmanConfig();
            if ($config->isConfigured()) {
                self::$client = new Client($config->accessToken, $config->resourceUrl . '/v1/', ConsoleLoggerFactory::getLogger(), true);
            }
        }
        return self::$client;
    }
}
