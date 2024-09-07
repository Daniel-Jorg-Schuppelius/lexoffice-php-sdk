<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use DateTime;
use APIToolkit\Contracts\Abstracts\NamedEntity;
use Psr\Log\LoggerInterface;

class Created extends NamedEntity {
    protected UserID $userId;
    protected string $userName;
    protected string $userEmail;
    protected DateTime $date;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getUserId(): UserID {
        return $this->userId;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getUserEmail(): string {
        return $this->userEmail;
    }

    public function getDate(): DateTime {
        return $this->date;
    }
}
