<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PaymentsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\Entities\Payments\Payment;

class PaymentsEndpoint extends EndpointAbstract {
    protected string $endpoint = 'payments';

    public function get(?ID $id = null): Payment {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting a payment');
        }

        self::logDebug('Fetching payment', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn () => Payment::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}")),
            "Payment fetched (ID: {$id->toString()})"
        );
    }
}
