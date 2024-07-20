<?php

declare(strict_types=1);

namespace Lexoffice\Exceptions;

use Exception;

class ApiException extends Exception {
    protected $response;

    public function __construct($message = '', int $code = 0, $response = null, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }

    public function getResponse() {
        return $this->response;
    }
}
