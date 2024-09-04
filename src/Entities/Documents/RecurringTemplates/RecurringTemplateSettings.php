<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\RecurringTemplates;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\ExecutionInterval;
use Lexoffice\Enums\ExecutionStatus;
use Lexoffice\Enums\ShippingType;
use Psr\Log\LoggerInterface;

class RecurringTemplateSettings extends NamedEntity {
    protected RecurringTemplateSettingsID $id;
    protected ?DateTime $startDate;
    protected ?DateTime $nextExecutionDate;
    protected ?DateTime $endDate;
    protected bool $finalize;
    protected ShippingType $shippingType;
    protected ExecutionInterval $executionInterval;
    protected bool $lastExecutionFailed;
    protected ?string $lastExecutionErrorMessage;
    protected ExecutionStatus $executionStatus;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getId(): RecurringTemplateSettingsID {
        return $this->id;
    }

    public function getStartDate(): ?DateTime {
        return $this->startDate;
    }

    public function getNextExecutionDate(): ?DateTime {
        return $this->nextExecutionDate;
    }

    public function getEndDate(): ?DateTime {
        return $this->endDate;
    }

    public function setFinalize(bool $finalize): void {
        $this->finalize = $finalize;
    }

    public function getShippingType(): ShippingType {
        return $this->shippingType;
    }

    public function getExecutionInterval(): ExecutionInterval {
        return $this->executionInterval;
    }

    public function getLastExecutionErrorMessage(): ?string {
        return $this->lastExecutionErrorMessage;
    }

    public function getExecutionStatus(): ExecutionStatus {
        return $this->executionStatus;
    }

    public function setStartDate(DateTime $startDate): void {
        $this->startDate = $startDate;
    }

    public function setNextExecutionDate(DateTime $nextExecutionDate): void {
        $this->nextExecutionDate = $nextExecutionDate;
    }

    public function setEndDate(DateTime $endDate): void {
        $this->endDate = $endDate;
    }

    public function setShippingType(ShippingType $shippingType): void {
        $this->shippingType = $shippingType;
    }

    public function setExecutionInterval(ExecutionInterval $executionInterval): void {
        $this->executionInterval = $executionInterval;
    }

    public function isFinalize(): bool {
        return $this->finalize;
    }

    public function isLastExecutionFailed(): bool {
        return $this->lastExecutionFailed;
    }

    public function toArray(): array {
        return $this->getArray('Y-m-d');
    }
}
