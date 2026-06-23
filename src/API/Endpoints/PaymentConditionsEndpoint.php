<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PaymentConditionsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PaymentConditions\{PaymentCondition, PaymentConditions};

class PaymentConditionsEndpoint extends EndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'payment-conditions';

    public function get(?ID $id = null): PaymentCondition {
        self::logErrorAndThrow(NotAllowedException::class, 'Getting a single payment condition is not allowed', [], null, 405);
    }

    public function list(array $options = []): PaymentConditions {
        self::logDebug('Listing payment conditions');

        return self::logDebugWithTimer(
            fn () => PaymentConditions::fromJson(parent::getContents([], $options)),
            'Payment conditions list fetched'
        );
    }
}
