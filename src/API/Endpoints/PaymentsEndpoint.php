<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PaymentsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Entities\Payments\Payment;
use APIToolkit\Entities\ID;

class PaymentsEndpoint extends EndpointAbstract {
    protected string $endpoint = 'payments';

    public function get(?ID $id = null): Payment {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return Payment::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }
}
