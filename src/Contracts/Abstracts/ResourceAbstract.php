<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ResourceAbstract.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Entities\{ID, Version};
use DateTime;
use Lexoffice\Contracts\Interfaces\{ExtendedTimestampableNamedEntityInterface, ResourceNamedEntityInterface};
use Psr\Log\LoggerInterface;

abstract class ResourceAbstract extends NamedEntity implements ExtendedTimestampableNamedEntityInterface, ResourceNamedEntityInterface {
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
