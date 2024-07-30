<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts\API;

use Lexoffice\Contracts\Interfaces\API\DocumentEndpointInterface;
use Lexoffice\Contracts\Interfaces\API\ResourceInterface;
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

abstract class DocumentEndpointAbstract extends EndpointAbstract implements DocumentEndpointInterface {
    abstract public function render(ID $id): DocumentFileID;
    abstract public function pursue(VoucherID $id, bool $finalize = false): ResourceInterface;
}
