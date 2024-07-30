<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

interface DocumentEndpointInterface extends EndpointInterface {
    public function render(ID $id): DocumentFileID;
    public function pursue(VoucherID $id, bool $finalize = false): ResourceInterface;
}
