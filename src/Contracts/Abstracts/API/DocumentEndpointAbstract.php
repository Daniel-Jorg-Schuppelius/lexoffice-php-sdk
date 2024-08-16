<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts\API;

use Lexoffice\Contracts\Interfaces\API\DocumentEndpointInterface;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Contracts\Interfaces\ResourceInterface;
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

abstract class DocumentEndpointAbstract extends BaseEndpointAbstract implements DocumentEndpointInterface {
    abstract public function create(NamedEntityInterface $data, ID $id = null): ResourceInterface;
    abstract public function get(ID $id): NamedEntityInterface;
    abstract public function render(ID $id): DocumentFileID;
    abstract public function pursue(VoucherID $id, bool $finalize = false): ResourceInterface;
}
