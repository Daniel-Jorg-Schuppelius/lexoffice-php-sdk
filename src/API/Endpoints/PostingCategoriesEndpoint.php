<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PostingCategoriesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PostingCategories\{PostingCategories, PostingCategory};

class PostingCategoriesEndpoint extends EndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'posting-categories';

    public function get(?ID $id = null): PostingCategory {
        self::logErrorAndThrow(NotAllowedException::class, 'Getting a single posting category is not allowed', [], null, 405);
    }

    public function list(array $options = []): PostingCategories {
        self::logDebug('Listing posting categories');

        return self::logDebugWithTimer(
            fn () => PostingCategories::fromJson(parent::getContents([], $options)),
            'Posting categories list fetched'
        );
    }
}
