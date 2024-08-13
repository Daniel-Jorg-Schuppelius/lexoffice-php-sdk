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
    public bool $finalize;
    public ShippingType $shippingType;
    public ExecutionInterval $executionInterval;
    protected bool $lastExecutionFailed;
    protected ?string $lastExecutionErrorMessage;
    protected ExecutionStatus $executionStatus;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
