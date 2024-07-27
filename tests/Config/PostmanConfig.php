<?php

namespace Tests\Config;

use Exception;

class PostmanConfig {
    public $resourceUrl;
    public $accessToken;

    public function __construct() {
        $this->setPostmanConfig();
    }

    private function setPostmanConfig() {
        $filePath = __DIR__ . '/../../.samples/postman_config.json';
        if (!file_exists($filePath)) {
            throw new Exception("Die Datei $filePath existiert nicht.");
        }

        $jsonContent = file_get_contents($filePath);
        $config = json_decode($jsonContent, true);

        $this->resourceUrl = null;
        $this->accessToken = null;

        foreach ($config['values'] as $value) {
            if ($value['key'] === 'resourceurl') {
                $this->resourceUrl = $value['value'];
            }
            if ($value['key'] === 'accessToken') {
                $this->accessToken = $value['value'];
            }
        }
    }
}
