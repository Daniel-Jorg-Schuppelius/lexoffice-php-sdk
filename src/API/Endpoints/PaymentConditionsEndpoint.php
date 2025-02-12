<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PaymentConditionsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PaymentConditions\PaymentCondition;
use Lexoffice\Entities\PaymentConditions\PaymentConditions;
use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;

class PaymentConditionsEndpoint extends EndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'payment-conditions';

    public function get(?ID $id = null): PaymentCondition {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function list(array $options = []): PaymentConditions {
        return PaymentConditions::fromJson(parent::getContents([], $options));
    }
}
