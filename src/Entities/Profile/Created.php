<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Created.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use DateTime;
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
