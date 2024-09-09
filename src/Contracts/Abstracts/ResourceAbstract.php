<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use DateTime;
use APIToolkit\Contracts\Abstracts\NamedEntity;
use Lexoffice\Contracts\Interfaces\ExtendedTimestampableInterface;
use Lexoffice\Contracts\Interfaces\ResourceInterface;
use APIToolkit\Entities\ID;
use Lexoffice\Entities\Version;
use Psr\Log\LoggerInterface;

abstract class ResourceAbstract extends NamedEntity implements ResourceInterface, ExtendedTimestampableInterface {
    protected ID $id;
    protected string $resourceUri;
    protected DateTime $createdDate;
    protected DateTime $updatedDate;
    protected Version $version;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
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
}