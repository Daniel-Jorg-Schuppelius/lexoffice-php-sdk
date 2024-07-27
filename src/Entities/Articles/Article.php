<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\ArticleType;
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Entities\Version;

class Article extends NamedEntity {
    protected ArticleID $id;
    protected OrganizationID $organizationId;
    protected DateTime $createdDate;
    protected DateTime $updatedDate;
    protected bool $archived;
    public string $title;
    public string $description;
    public ArticleType $type;
    public string $articleNumber;
    public string $gtin;
    public string $note;
    public string $unitName;
    public Price $price;
    protected Version $version;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
