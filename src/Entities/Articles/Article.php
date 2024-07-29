<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableInterface;
use Lexoffice\Enums\ArticleType;
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Entities\Version;

class Article extends NamedEntity implements IdentifiableInterface, OrganizationIdentifiableInterface {
    protected ArticleID $id;
    protected OrganizationID $organizationId;
    protected DateTime $createdDate;
    protected DateTime $updatedDate;
    protected bool $archived;
    public string $title;
    public ?string $description;
    public ArticleType $type;
    public ?string $articleNumber;
    public ?string $gtin;
    public ?string $note;
    public string $unitName;
    public Price $price;
    protected Version $version;

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getID(): ArticleID {
        return $this->id;
    }

    public function getOrganizationID(): OrganizationID {
        return $this->organizationId;
    }
}
