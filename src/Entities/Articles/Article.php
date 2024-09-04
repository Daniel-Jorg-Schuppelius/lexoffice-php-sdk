<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\ArchivableInterface;
use Lexoffice\Contracts\Interfaces\ExtendedTimestampableInterface;
use Lexoffice\Contracts\Interfaces\IdentifiableInterface;
use Lexoffice\Contracts\Interfaces\OrganizationIdentifiableInterface;
use Lexoffice\Contracts\Interfaces\VersionableInterface;
use Lexoffice\Enums\ArticleType;
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Entities\Version;
use Psr\Log\LoggerInterface;

class Article extends NamedEntity implements IdentifiableInterface, OrganizationIdentifiableInterface, ArchivableInterface, ExtendedTimestampableInterface, VersionableInterface {
    public ?ArticleID $id;
    public ?OrganizationID $organizationId;
    protected ?DateTime $createdDate;
    protected ?DateTime $updatedDate;
    protected ?bool $archived;
    public string $title;
    public ?string $description;
    public ArticleType $type;
    public ?string $articleNumber;
    public ?string $gtin;
    public ?string $note;
    public string $unitName;
    public Price $price;
    protected ?Version $version;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): ?ArticleID {
        return $this->id ?? null;
    }

    public function getOrganizationID(): ?OrganizationID {
        return $this->organizationId ?? null;
    }

    public function getCreatedDate(): ?DateTime {
        return $this->createdDate ?? null;
    }

    public function getUpdatedDate(): ?DateTime {
        return $this->updatedDate ?? null;
    }

    public function getVersion(): ?Version {
        return $this->version ?? null;
    }

    public function isArchived(): bool {
        return $this->archived ?? false;
    }
}
