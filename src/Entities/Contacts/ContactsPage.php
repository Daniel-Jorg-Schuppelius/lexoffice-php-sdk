<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedPage;

class ContactsPage extends NamedPage {
    public function __construct($data = null) {
        $this->valueClassName = Contacts::class;
        parent::__construct($data);
    }
}
