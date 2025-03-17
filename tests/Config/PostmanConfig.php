<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PostmanConfig.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Config;

use ConfigToolkit\ConfigLoader;
use Exception;
use Psr\Log\LoggerInterface;

class PostmanConfig {
    private const CONFIG_PATH = __DIR__ . '/../../.samples/postman_config.json';

    private ConfigLoader $configLoader;
    private static ?LoggerInterface $logger = null;

    public function __construct(?LoggerInterface $logger = null) {
        self::$logger = $logger;
        $this->configLoader = ConfigLoader::getInstance(self::$logger);
        $this->loadConfig();
    }

    public function isConfigured(): bool {
        return $this->getResourceUrl() !== null && $this->getAccessToken() !== null;
    }

    private function loadConfig(): void {
        try {
            if (!file_exists(self::CONFIG_PATH)) {
                throw new Exception("Postman-Config-Datei nicht gefunden: " . self::CONFIG_PATH);
            }

            $this->configLoader->loadConfigFile(self::CONFIG_PATH);
        } catch (Exception $e) {
            if (self::$logger) {
                self::$logger->error("Fehler beim Laden der Postman-Config: " . $e->getMessage());
            } else {
                error_log("Fehler beim Laden der Postman-Config: " . $e->getMessage());
            }
        }
    }

    public function getResourceUrl(): ?string {
        return $this->configLoader->get("values", "resourceurl");
    }

    public function getAccessToken(): ?string {
        return $this->configLoader->get("values", "accessToken");
    }
}
