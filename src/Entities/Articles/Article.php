<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Article.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\{ArchivableNamedEntityInterface, IdentifiableNamedEntityInterface, VersionableNamedEntityInterface};
use APIToolkit\Entities\Version;
use DateTime;
use Lexoffice\Contracts\Interfaces\{ExtendedTimestampableNamedEntityInterface, OrganizationIdentifiableNamedEntityInterface};
use Lexoffice\Entities\Profile\OrganizationID;
use Lexoffice\Enums\ArticleType;
use Psr\Log\LoggerInterface;

class Article extends NamedEntity implements ArchivableNamedEntityInterface, ExtendedTimestampableNamedEntityInterface, IdentifiableNamedEntityInterface, OrganizationIdentifiableNamedEntityInterface, VersionableNamedEntityInterface {
    protected ?ArticleID $id;
    protected ?OrganizationID $organizationId;
    protected ?DateTime $createdDate;
    protected ?DateTime $updatedDate;
    protected ?bool $archived;
    protected string $title;
    protected ?string $description;
    protected ArticleType $type;
    protected ?string $articleNumber;
    protected ?string $gtin;
    protected ?string $note;
    protected string $unitName;
    protected Price $price;
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

    public function getTitle(): string {
        return $this->title;
    }

    public function getDescription(): ?string {
        return $this->description ?? null;
    }

    public function getType(): ArticleType {
        return $this->type;
    }

    public function getArticleNumber(): ?string {
        return $this->articleNumber ?? null;
    }

    public function getGtin(): ?string {
        return $this->gtin ?? null;
    }

    public function getNote(): ?string {
        return $this->note ?? null;
    }

    public function getUnitName(): string {
        return $this->unitName;
    }

    public function getPrice(): Price {
        return $this->price;
    }

    public function setID(ArticleID $id): void {
        $this->id = $id;
    }

    public function setOrganizationID(OrganizationID $organizationId): void {
        $this->organizationId = $organizationId;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function setType(ArticleType $type): void {
        $this->type = $type;
    }

    public function setArticleNumber(?string $articleNumber): void {
        $this->articleNumber = $articleNumber;
    }

    public function setGtin(?string $gtin): void {
        $this->gtin = $gtin;
    }

    public function setNote(?string $note): void {
        $this->note = $note;
    }

    public function setUnitName(string $unitName): void {
        $this->unitName = $unitName;
    }

    public function setPrice(Price $price): void {
        $this->price = $price;
    }
}
