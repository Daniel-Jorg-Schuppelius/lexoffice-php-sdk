<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use APIToolkit\Contracts\Interfaces\API\EndpointInterface;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use Lexoffice\Contracts\Interfaces\ResourceInterface;
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\Vouchers\VoucherID;

interface DocumentEndpointInterface extends EndpointInterface {
    public function create(NamedEntityInterface $data, ID $id = null): ResourceInterface;
    public function render(ID $id): DocumentFileID;
    public function pursue(VoucherID $id, bool $finalize = false): ResourceInterface;
}