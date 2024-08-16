<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Interfaces\API;

use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Contracts\Interfaces\ResourceInterface;
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

interface DocumentEndpointInterface extends BaseEndpointInterface {
    public function create(NamedEntityInterface $data, ID $id = null): ResourceInterface;
    public function render(ID $id): DocumentFileID;
    public function pursue(VoucherID $id, bool $finalize = false): ResourceInterface;
}
