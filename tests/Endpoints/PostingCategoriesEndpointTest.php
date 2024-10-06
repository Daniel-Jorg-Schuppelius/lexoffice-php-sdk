<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PostingCategoriesEndpointTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Tests\Endpoints;

use Lexoffice\API\Endpoints\PostingCategoriesEndpoint;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PostingCategories\PostingCategories;
use Tests\Contracts\EndpointTest;

class PostingCategoriesEndpointTest extends EndpointTest {
    private ?ListableEndpointInterface $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new PostingCategoriesEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }

    public function testGetPostingCategoriesAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $postingCategories = $this->endpoint->list();
        $this->assertInstanceOf(PostingCategories::class, $postingCategories);
    }
}
