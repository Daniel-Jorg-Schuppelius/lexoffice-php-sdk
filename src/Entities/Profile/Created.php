<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use DateTime;
use Lexoffice\Contracts\Abstracts\NamedEntity;

class Created extends NamedEntity {
    public UserID $userId;
    public string $userName;
    public string $userEmail;
    public DateTime $date;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
