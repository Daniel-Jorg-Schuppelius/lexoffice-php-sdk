# Lexoffice PHP SDK

[![PHP Version](https://img.shields.io/badge/php-8.2%20|%208.3%20|%208.4-blue)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)
[![Packagist](https://img.shields.io/packagist/v/daniel-jorg-schuppelius/lexoffice-php-sdk)](https://packagist.org/packages/daniel-jorg-schuppelius/lexoffice-php-sdk)

Ein PHP SDK für die **Lexoffice API**, das programmatischen Zugriff auf die deutsche Buchhaltungssoftware ermöglicht.

Inspiriert vom Projekt [eike-grundke/lexoffice-php-sdk](https://github.com/helsinki-systems/lexoffice-php-sdk), wurde die Struktur komplett überarbeitet.

## 🚀 Features

- **Bearer Token Authentifizierung**: Einfache API-Key Authentifizierung
- **Domain-Driven Design**: Strikte Trennung zwischen API-Clients, Endpoints, Entities und Contracts
- **20 Endpoints** für umfassende Lexoffice-Integration
- **Umfassende API-Abdeckung** für verschiedene Bereiche:
  - Artikel (Articles) - 1 Endpoint
  - Kontakte (Contacts) - 1 Endpoint
  - Dokumente (Documents) - 8 Endpoints
  - Zahlungen (Payments) - 1 Endpoint
  - Vouchers - 2 Endpoints
  - Event-Subscriptions - 1 Endpoint
  - Profile, Länder, Dateien und mehr

## 📋 Voraussetzungen

- PHP 8.2, 8.3 oder 8.4
- Lexoffice Account mit API-Zugang
- Composer

## 📦 Installation

```bash
composer require daniel-jorg-schuppelius/lexoffice-php-sdk
```

## ⚙️ Konfiguration

### API-Schlüssel

Um die API zu nutzen, benötigen Sie einen API-Schlüssel aus Ihrem Lexoffice-Account:
1. Melden Sie sich bei Lexoffice an
2. Gehen Sie zu **Einstellungen** → **Öffentliche API**
3. Erstellen Sie einen neuen API-Schlüssel

### Verbindung zur Lexoffice API

```php
use Lexoffice\API\Client;

$client = new Client('your-api-key');
```

## 📚 Verwendung

### Beispiel: Artikel abrufen

```php
use Lexoffice\API\Client;
use Lexoffice\API\Endpoints\ArticlesEndpoint;

$client = new Client('your-api-key');
$endpoint = new ArticlesEndpoint($client);

// Einzelnen Artikel abrufen
$article = $endpoint->get($articleId);
```

### Beispiel: Kontakte abrufen

```php
use Lexoffice\API\Client;
use Lexoffice\API\Endpoints\ContactsEndpoint;

$client = new Client('your-api-key');
$endpoint = new ContactsEndpoint($client);

// Kontakt abrufen
$contact = $endpoint->get($contactId);
```

### Beispiel: Rechnung erstellen

```php
use Lexoffice\API\Client;
use Lexoffice\API\Endpoints\Documents\InvoicesEndpoint;
use Lexoffice\Entities\Documents\Invoices\Invoice;

$client = new Client('your-api-key');
$endpoint = new InvoicesEndpoint($client);

// Rechnung erstellen
$invoice = new Invoice($invoiceData);
$result = $endpoint->create($invoice);
```

### Beispiel: Rechnung zu einem Kontakt aus einem Angebot

```php
use Lexoffice\API\Client;
use Lexoffice\API\Endpoints\Documents\InvoicesEndpoint;
use Lexoffice\Entities\Documents\Invoices\Invoice;
use Lexoffice\Entities\Vouchers\VoucherID;

$invoices = new InvoicesEndpoint(new Client('your-api-key'));

$invoice = Invoice::fromArray([
    'voucherDate' => '2026-10-21T00:00:00.000+02:00',
    // Ohne countryCode gilt die Adresse des Kontakts; das SDK ergänzt kein Land.
    'address' => ['contactId' => 'be9475f4-ef80-442b-8ab9-3ab8b1a2aeb9'],
    'lineItems' => [[
        'type' => 'custom',
        'name' => 'Montage',
        'quantity' => 1.5,
        'unitName' => 'Stunde',
        // Je nach taxType netAmount oder grossAmount — gesendet wird nur, was gesetzt ist.
        'unitPrice' => ['currency' => 'EUR', 'netAmount' => 80.0, 'taxRatePercentage' => 19.0],
    ]],
    'totalPrice' => ['currency' => 'EUR'],
    'taxConditions' => ['taxType' => 'net'],
    'shippingConditions' => ['shippingType' => 'service', 'shippingDate' => '2026-10-21T00:00:00.000+02:00'],
]);

// POST /invoices?precedingSalesVoucherId={Angebot}&finalize=true
$resource = $invoices->create($invoice, new VoucherID($quotationId), finalize: true);
```

### Beispiel: Belegdatei herunterladen

```php
use Lexoffice\API\Endpoints\Documents\InvoicesEndpoint;
use Lexoffice\API\Endpoints\FilesEndpoint;

// GET /invoices/{id}/file — bei einer XRechnung liefert application/xml das XML.
$file = (new InvoicesEndpoint($client))->downloadContent($resource->getId(), 'application/xml');
$file->getContent();     // Bytes
$file->getMimeType();    // z. B. application/xml
$file->getFileName();    // aus Content-Disposition, sonst null

// Belegbilder von Buchungsbelegen: GET /files/{id}
foreach ($vouchers->get($voucherId)->getFiles() ?? [] as $fileId) {
    $image = (new FilesEndpoint($client))->downloadContent($fileId);
}
```

### Beispiel: Profil abrufen

```php
use Lexoffice\API\Client;
use Lexoffice\API\Endpoints\ProfileEndpoint;

$client = new Client('your-api-key');
$endpoint = new ProfileEndpoint($client);

// Firmenprofil abrufen
$profile = $endpoint->get();
```

### Beispiel: Eingangsrechnung als Beleg mit Originaldatei

```php
use Lexoffice\API\Client;
use Lexoffice\API\Endpoints\VouchersEndpoint;
use Lexoffice\Entities\Files\File;
use Lexoffice\Entities\Vouchers\Voucher;

$client = new Client('your-api-key');
$vouchers = new VouchersEndpoint($client);

// „Zu prüfen“: Nummer, Datum, Beträge und Positionen sind optional.
$resource = $vouchers->create(Voucher::fromArray([
    'type' => 'purchaseinvoice',
    'voucherStatus' => 'unchecked',
    'voucherNumber' => 'RE-4711',
    'voucherDate' => '2026-10-01',
    'taxType' => 'gross',
    'useCollectiveContact' => true,
    'contactName' => 'Muster GmbH',
]));

// Datei an genau diesen Beleg hängen (PDF, Bild oder E-Rechnungs-XML).
$vouchers->addFile($resource->getId(), new File([
    'filePath' => '/pfad/zur/rechnung.xml',
    'fileName' => 'RE-4711.xml',
]));
```

`FilesEndpoint::upload()` (`type=voucher`) legt dagegen in Lexware selbst einen
neuen Beleg an; dessen ID liefert `FileResource::getVoucherId()`.

## 🔄 Version 2.0.0

Korrekturen gegen die API-Referenz, nicht abwärtskompatibel (nullbare Getter,
`pursue()`); Details und Begründungen in
[docs/NOTES.md](docs/NOTES.md#200). Für Aufrufer relevant:

- `isValid()` aller ID-Klassen prüft auf UUID statt auf eine Zahl; Belege mit
  `address.contactId` lassen sich anlegen.
- Belegadresse: kein vorbelegtes `countryCode: DE` mehr im Body;
  `getContactPerson()` liefert `?string`.
- `UnitPrice` sendet nur gesetzte Beträge; `getTaxRatePercentage()` und
  `Articles\Price::getTaxRate()` liefern `?float` ohne Vorgabe 0.
- `create()` reicht den Vorgänger als `precedingSalesVoucherId` durch,
  `pursue()` nimmt den Beleg als dritten Parameter.
- Neu: `downloadContent()` an `FilesEndpoint` und allen Verkaufsbeleg-Endpunkten
  (Bytes, Medientyp, Dateiname).
- Nullbare Getter: `DeliveryNote::getShippingConditions()`,
  `VoucherList\Voucher::getVoucherType()`, `PaymentItem::getPaymentItemType()`,
  `Payment::getPaidDate()`, `EventSubscription::getEventType()`;
  `Vouchers\Voucher::getFiles()` liefert `FileIDs`.
- common-toolkit-Untergrenze `^1.34 || ^2.0`.

## 🏗️ Projektstruktur

```
docs/
├── lexoffice-API-Samples.postman_collection.json  # Postman Collection (korrigiert)
└── NOTES.md                        # Dokumentierte Abweichungen zur offiziellen API

tools/
└── check-endpoint-coverage.php     # Prüft SDK-Abdeckung gegen Postman Collection

src/
├── API/
│   ├── Client.php                  # API Client mit Bearer Auth
│   └── Endpoints/
│       ├── ArticlesEndpoint.php
│       ├── ContactsEndpoint.php
│       ├── CountriesEndpoint.php
│       ├── EventSubscriptionsEndpoint.php
│       ├── FilesEndpoint.php
│       ├── PaymentConditionsEndpoint.php
│       ├── PaymentsEndpoint.php
│       ├── PostingCategoriesEndpoint.php
│       ├── PrintLayoutsEndpoint.php
│       ├── ProfileEndpoint.php
│       ├── VoucherListEndpoint.php
│       ├── VouchersEndpoint.php
│       └── Documents/              # 8 Dokument-Endpoints
│           ├── CreditNotesEndpoint.php
│           ├── DeliveryNotesEndpoint.php
│           ├── DownPaymentInvoicesEndpoint.php
│           ├── DunningsEndpoint.php
│           ├── InvoicesEndpoint.php
│           ├── OrderConfirmationsEndpoint.php
│           ├── QuotationsEndpoint.php
│           └── RecurringTemplatesEndpoint.php
├── Contracts/
│   ├── Abstracts/                  # Basis-Klassen
│   └── Interfaces/                 # Interface-Definitionen
├── Entities/                       # Domain-Entities
└── Enums/                          # Enumerations (20 Typen)
```

## 🔌 API-Endpunkte

### Artikel & Kontakte

| Endpoint | Beschreibung |
|----------|--------------|
| `ArticlesEndpoint` | Artikelverwaltung |
| `ContactsEndpoint` | Kontaktverwaltung |

### Dokumente

| Endpoint | Beschreibung |
|----------|--------------|
| `InvoicesEndpoint` | Rechnungen |
| `CreditNotesEndpoint` | Gutschriften |
| `DeliveryNotesEndpoint` | Lieferscheine |
| `DownPaymentInvoicesEndpoint` | Abschlagsrechnungen |
| `DunningsEndpoint` | Mahnungen |
| `OrderConfirmationsEndpoint` | Auftragsbestätigungen |
| `QuotationsEndpoint` | Angebote |
| `RecurringTemplatesEndpoint` | Wiederkehrende Vorlagen |

### Zahlungen & Finanzen

| Endpoint | Beschreibung |
|----------|--------------|
| `PaymentsEndpoint` | Zahlungen |
| `PaymentConditionsEndpoint` | Zahlungsbedingungen |
| `VouchersEndpoint` | Belege |
| `VoucherListEndpoint` | Belegliste |
| `PostingCategoriesEndpoint` | Buchungskategorien |

### Sonstiges

| Endpoint | Beschreibung |
|----------|--------------|
| `ProfileEndpoint` | Firmenprofil |
| `CountriesEndpoint` | Länder |
| `FilesEndpoint` | Dateien |
| `PrintLayoutsEndpoint` | Drucklayouts |
| `EventSubscriptionsEndpoint` | Event-Webhooks |

### Eingehende Webhooks

Das SDK verwaltet Event-Subscriptions (anlegen, lesen, löschen), enthält aber
bewusst **keine Signaturprüfung** für die eingehenden Callbacks: eine
Subscription besteht nur aus `eventType` und `callbackUrl`, ein gemeinsames
Secret gibt es nicht. Ein eingehendes Event ist deshalb erst dann belastbar,
wenn die referenzierte Ressource über die API nachgeladen wurde — der Callback
selbst ist ein Hinweis, kein Beleg. (`APIToolkit\API\Webhook\WebhookVerifier`
setzt eine HMAC-Signatur voraus und passt hier nicht.)

## 🧪 Tests

### Test-Konfiguration

1. Kopieren Sie `.samples/postman_config.json.sample` nach `.samples/postman_config.json`
2. Tragen Sie Ihren Lexoffice API-Key ein

Die Vorgabe-Adresse ist seit v1.3.0 `https://api.lexware.io` (Umbenennung vom
27.05.2025); `https://api.lexoffice.io` wird weiter akzeptiert.

### Tests ausführen

```bash
composer test
# oder
vendor/bin/phpunit
```

> **Hinweis:** Die meisten Tests erfordern einen gültigen API-Key und sind daher standardmäßig deaktiviert.

## 📖 Abhängigkeiten

- [php-api-toolkit](https://github.com/daniel-jorg-schuppelius/php-api-toolkit) (^2.8) - Basis-Klassen für Clients, Endpoints und Entities
- [php-common-toolkit](https://github.com/daniel-jorg-schuppelius/php-common-toolkit) (^1.34 || ^2.0) - Geldbeträge, Dateien, UUID-Prüfung
- [GuzzleHttp](https://github.com/guzzle/guzzle) - HTTP Client
- [PSR-3 Logger](https://www.php-fig.org/psr/psr-3/) - Logging-Interface

### Toolkit-Features

Das SDK nutzt die erweiterten Funktionen des php-api-toolkit:

| Feature | Beschreibung |
|---------|--------------|
| **E-Mail-Validierung** | `EmailAddress::isValid()`, `getDomain()`, `isDisposable()` |
| **Telefonnummer-Formatierung** | `PhoneNumber::toE164()`, `format()`, `isGermanMobile()` |
| **Adress-Validierung** | `Address::isValidZip()`, `getGermanState()`, `getFullAddress()` |
| **Personen-Handling** | Strukturierte Vor-/Nachname-Verwaltung mit Anrede |

## 📄 Lizenz

Dieses Projekt ist unter der [MIT-Lizenz](LICENSE) lizenziert.

## 💖 Unterstützung

Wenn Ihnen dieses Projekt gefällt und es Ihnen bei Ihrer Arbeit hilft, würde ich mich sehr über eine Spende freuen!

[![GitHub Sponsors](https://img.shields.io/badge/Sponsor-GitHub-ea4aaa?logo=github)](https://github.com/sponsors/Daniel-Jorg-Schuppelius)
[![PayPal](https://img.shields.io/badge/Spenden-PayPal-blue?logo=paypal)](https://www.paypal.com/donate/?hosted_button_id=X43UQQVDKL76Y)

## 👤 Autor

**Daniel Jörg Schuppelius**
- Website: [schuppelius.org](https://schuppelius.org)
- E-Mail: info@schuppelius.org
