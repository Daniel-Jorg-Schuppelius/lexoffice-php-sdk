<?php
/*
 * Created on   : Wed Oct 21 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : IdentifierTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Entities;

use Lexoffice\Contracts\Abstracts\UuidID;
use Lexoffice\Entities\Articles\ArticleID;
use Lexoffice\Entities\Contacts\ContactID;
use Lexoffice\Entities\Documents\{ContactID as DocumentContactID, DocumentFileID, PrintLayoutID as DocumentPrintLayoutID};
use Lexoffice\Entities\Documents\DownPaymentInvoices\ClosingInvoiceID;
use Lexoffice\Entities\Documents\Invoices\RecurringTemplateID;
use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplateSettingsID;
use Lexoffice\Entities\EventSubscriptions\SubscriptionID;
use Lexoffice\Entities\Files\FileID;
use Lexoffice\Entities\PostingCategories\PostingCategoryID;
use Lexoffice\Entities\PrintLayouts\PrintLayoutID;
use Lexoffice\Entities\Profile\{ConnectionID, OrganizationID, UserID};
use Lexoffice\Entities\Vouchers\{CategoryID, VoucherID};
use Lexoffice\Entities\Vouchers\ContactID as VoucherContactID;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Alle Lexware-IDs sind UUIDs; bis v1.3.2 prüften die ID-Klassen auf eine Zahl
 * und setzten ihren Entity-Namen erst nach der Prüfung des Eingangs.
 */
class IdentifierTest extends TestCase {
    private const UUID = '8f8664a8-fd86-11e1-a21f-0800200c9a66';

    /**
     * @return array<string, array{class-string<UuidID>, string}>
     */
    public static function identifiers(): array {
        return [
            'ArticleID' => [ArticleID::class, 'id'],
            'Contacts\ContactID' => [ContactID::class, 'id'],
            'Documents\ContactID' => [DocumentContactID::class, 'contactId'],
            'Vouchers\ContactID' => [VoucherContactID::class, 'contactId'],
            'DocumentFileID' => [DocumentFileID::class, 'documentFileId'],
            'ClosingInvoiceID' => [ClosingInvoiceID::class, 'closingInvoiceId'],
            'RecurringTemplateID' => [RecurringTemplateID::class, 'recurringTemplateId'],
            'Documents\PrintLayoutID' => [DocumentPrintLayoutID::class, 'printLayoutId'],
            'PrintLayouts\PrintLayoutID' => [PrintLayoutID::class, 'id'],
            'RecurringTemplateSettingsID' => [RecurringTemplateSettingsID::class, 'id'],
            'SubscriptionID' => [SubscriptionID::class, 'subscriptionId'],
            'FileID' => [FileID::class, 'id'],
            'PostingCategoryID' => [PostingCategoryID::class, 'id'],
            'ConnectionID' => [ConnectionID::class, 'connectionId'],
            'OrganizationID' => [OrganizationID::class, 'organizationId'],
            'UserID' => [UserID::class, 'userId'],
            'CategoryID' => [CategoryID::class, 'categoryId'],
            'VoucherID' => [VoucherID::class, 'id'],
        ];
    }

    /**
     * @param class-string<UuidID> $class
     */
    #[DataProvider('identifiers')]
    public function test_uuid_is_valid_and_keyed_input_is_accepted(string $class, string $entityName): void {
        $id = new $class(self::UUID);
        $this->assertTrue($id->isValid());
        $this->assertSame([$entityName => self::UUID], $id->toArray());

        $keyed = $class::fromArray([$entityName => self::UUID]);
        $this->assertSame(self::UUID, $keyed->toString());
        $this->assertSame($entityName, $keyed->getEntityName());
    }

    /**
     * @param class-string<UuidID> $class
     */
    #[DataProvider('identifiers')]
    public function test_non_uuid_is_invalid(string $class): void {
        $this->assertFalse((new $class('4711'))->isValid());
        $this->assertFalse((new $class(4711))->isValid());
        $this->assertFalse((new $class)->isValid());
    }
}
