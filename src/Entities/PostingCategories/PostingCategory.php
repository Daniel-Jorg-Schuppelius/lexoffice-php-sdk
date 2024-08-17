<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PostingCategories;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Lexoffice\Enums\PostingCategoryType;
use Psr\Log\LoggerInterface;

class PostingCategory extends NamedEntity implements IdentifiableInterface {
    public PostingCategoryID $id;
    public string $name;
    public PostingCategoryType $type;
    public ?bool $organizationDefault;
    public bool $contactRequired;
    public bool $splitAllowed;
    public string $groupName;
    public ?string $paymentTermLabelTemplate;
    public ?int $paymentTermDuration;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): PostingCategoryID {
        return $this->id;
    }
}
