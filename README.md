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

### Beispiel: Profil abrufen

```php
use Lexoffice\API\Client;
use Lexoffice\API\Endpoints\ProfileEndpoint;

$client = new Client('your-api-key');
$endpoint = new ProfileEndpoint($client);

// Firmenprofil abrufen
$profile = $endpoint->get();
```

## 🏗️ Projektstruktur

```
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
└── Enums/                          # Enumerations (20+ Typen)
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

## 🧪 Tests

### Test-Konfiguration

1. Kopieren Sie `.samples/postman_config.json.sample` nach `.samples/postman_config.json`
2. Tragen Sie Ihren Lexoffice API-Key ein

### Tests ausführen

```bash
composer test
# oder
vendor/bin/phpunit
```

> **Hinweis:** Die meisten Tests erfordern einen gültigen API-Key und sind daher standardmäßig deaktiviert.

## 📖 Abhängigkeiten

- [php-api-toolkit](https://github.com/daniel-jorg-schuppelius/php-api-toolkit) (^2.0) - Basis-Klassen für Clients, Endpoints und Entities
- [GuzzleHttp](https://github.com/guzzle/guzzle) - HTTP Client
- [PSR-3 Logger](https://www.php-fig.org/psr/psr-3/) - Logging-Interface

## 📄 Lizenz

Dieses Projekt ist unter der [MIT-Lizenz](LICENSE) lizenziert.

## � Unterstützung

Wenn Ihnen dieses Projekt gefällt und es Ihnen bei Ihrer Arbeit hilft, würde ich mich sehr über eine Spende freuen!

[![GitHub Sponsors](https://img.shields.io/badge/Sponsor-GitHub-ea4aaa?logo=github)](https://github.com/sponsors/Daniel-Jorg-Schuppelius)
[![PayPal](https://img.shields.io/badge/Spenden-PayPal-blue?logo=paypal)](https://www.paypal.com/donate/?hosted_button_id=X43UQQVDKL76Y)

## 👤 Autor

**Daniel Jörg Schuppelius**
- Website: [schuppelius.org](https://schuppelius.org)
- E-Mail: info@schuppelius.org
