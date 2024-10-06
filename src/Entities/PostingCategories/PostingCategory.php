<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PostingCategory.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\PostingCategories;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use APIToolkit\Contracts\Interfaces\NamedEntityInterfaces\IdentifiableNamedEntityInterface;
use Lexoffice\Enums\PostingCategoryType;
use Psr\Log\LoggerInterface;

class PostingCategory extends NamedEntity implements IdentifiableNamedEntityInterface {
    protected PostingCategoryID $id;
    protected string $name;
    protected PostingCategoryType $type;
    protected ?bool $organizationDefault;
    protected bool $contactRequired;
    protected bool $splitAllowed;
    protected string $groupName;
    protected ?string $paymentTermLabelTemplate;
    protected ?int $paymentTermDuration;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getID(): PostingCategoryID {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getType(): PostingCategoryType {
        return $this->type;
    }

    public function getGroupName(): string {
        return $this->groupName;
    }

    public function getPaymentTermLabelTemplate(): ?string {
        return $this->paymentTermLabelTemplate;
    }

    public function getPaymentTermDuration(): ?int {
        return $this->paymentTermDuration;
    }

    public function isOrganizationDefault(): ?bool {
        return $this->organizationDefault;
    }

    public function isContactRequired(): bool {
        return $this->contactRequired;
    }

    public function isSplitAllowed(): bool {
        return $this->splitAllowed;
    }
}
