<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PostmanConfig.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Tests\Config;

class PostmanConfig {
    public ?string $resourceUrl = null;
    public ?string $accessToken = null;

    public function __construct() {
        $this->setPostmanConfig();
    }

    public function isConfigured(): bool {
        return !is_null($this->resourceUrl) && !is_null($this->accessToken);
    }

    private function setPostmanConfig() {
        $filePath = __DIR__ . '/../../.samples/postman_config.json';
        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $config = json_decode($jsonContent, true);

            foreach ($config['values'] as $value) {
                if ($value['key'] === 'resourceurl') {
                    $this->resourceUrl = $value['value'];
                }
                if ($value['key'] === 'accessToken') {
                    $this->accessToken = $value['value'];
                }
            }
        } else {
            error_log('Postman config file not found, please create one at ../../.samples/postman_config.json');
        }
    }
}
