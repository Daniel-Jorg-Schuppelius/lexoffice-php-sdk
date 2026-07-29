<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : TestAPIClientFactory.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Tests;

use APIToolkit\Contracts\Interfaces\API\ApiClientInterface;
use APIToolkit\Testing\TestLoggerFactory;
use Lexoffice\API\Client;
use Tests\Config\PostmanConfig;

class TestAPIClientFactory {
    private static ?ApiClientInterface $client = null;

    public static function getClient(): ApiClientInterface {
        if (self::$client === null) {
            $logger = TestLoggerFactory::get('LEXOFFICE');
            $config = new PostmanConfig($logger);
            self::$client = new Client($config->getAccessToken(), $config->getResourceUrl() ?? Client::DEFAULT_BASE_URL, $logger, true);
        }
        return self::$client;
    }
}
