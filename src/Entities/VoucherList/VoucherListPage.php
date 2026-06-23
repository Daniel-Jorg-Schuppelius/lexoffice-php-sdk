<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : VoucherListPage.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\VoucherList;

use Lexoffice\Contracts\Abstracts\NamedPage;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class VoucherListPage extends NamedPage {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = Vouchers::class;
        parent::__construct($data, $logger);
    }

    public function getContent(): Vouchers {
        $content = parent::getContent();

        if (!$content instanceof Vouchers) {
            self::logErrorAndThrow(UnexpectedValueException::class, 'VoucherListPage content must be a Vouchers instance');
        }

        return $content;
    }
}
