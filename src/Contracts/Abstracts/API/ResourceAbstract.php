<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts\API;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\API\ResourceInterface;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Version;

abstract class ResourceAbstract extends NamedEntity implements ResourceInterface {
    protected ID $id;
    protected string $resourceUri;
    protected DateTime $createdDate;
    protected DateTime $updatedDate;
    protected Version $version;

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getId(): ID {
        return $this->id;
    }

    public function getResourceUri(): string {
        return $this->resourceUri;
    }

    public function getCreatedDate(): DateTime {
        return $this->createdDate;
    }

    public function getUpdatedDate(): DateTime {
        return $this->updatedDate;
    }

    abstract public function getResource(): NamedEntityInterface;
}
