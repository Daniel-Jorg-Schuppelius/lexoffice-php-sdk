# Lexoffice PHP SDK - AI Coding Agent Instructions

## Project Overview
This is a PHP SDK for the Lexoffice API, completely rewritten with modern PHP patterns (8.2+). It uses the APIToolkit library as a foundation and follows strict typing, PSR standards, and clean architecture principles.

## Architecture & Core Concepts

### Layer Structure
- **API Layer** (`src/API/`): HTTP client and endpoint implementations
- **Entities** (`src/Entities/`): Domain models with JSON serialization/deserialization
- **Contracts** (`src/Contracts/`): Interfaces defining behavior contracts
- **Enums** (`src/Enums/`): Typed enumerations for API constants

### Key Patterns

#### Endpoint Pattern
All endpoints extend `EndpointAbstract` and implement specific interfaces:
- `ClassicEndpointInterface`: CRUD operations (create, update, delete)
- `SearchableEndpointInterface`: Paginated search functionality
- Each endpoint maps to a Lexoffice API resource (articles, contacts, vouchers, etc.)

#### Entity Pattern
Entities extend `NamedEntity` from APIToolkit and implement multiple interfaces:
- `IdentifiableNamedEntityInterface`: Has an ID property
- `OrganizationIdentifiableNamedEntityInterface`: Belongs to an organization
- `ExtendedTimestampableNamedEntityInterface`: Has created/updated timestamps
- `VersionableNamedEntityInterface`: Has version control

#### Resource vs Entity Distinction
- **Entities** (e.g., `Article`): Full domain objects with all properties
- **Resources** (e.g., `ArticleResource`): API response wrappers, often minimal data

### Client Configuration
The `Client` class extends `ClientAbstract` with:
- Bearer token authentication
- Rate limiting (0.65s interval between requests)
- Retry logic with configurable attempts
- Base URL: `https://api.lexoffice.io/v1/`

## Development Workflow

### Testing
- Run tests: `composer test` or `vendor/bin/phpunit`
- Tests often have `$this->apiDisabled = true` to prevent actual API calls
- Test structure mirrors source structure (`tests/Endpoints/`, `tests/Entities/`)
- Use `TestAPIClientFactory` for consistent client creation in tests

### Entity Development
When creating entities:
1. Extend `NamedEntity` and implement relevant interfaces
2. Use typed properties with proper nullability
3. Include `fromArray()` and `toArray()` methods for JSON handling
4. Add proper PHPDoc with `@var` annotations for complex types

### Enum Usage
Use PHP 8.1+ backed enums for API constants:
```php
enum ArticleType: string {
    case PRODUCT = 'PRODUCT';
    case SERVICE = 'SERVICE';
}
```

### ID Handling
Each domain has its own ID class extending `APIToolkit\Entities\ID`:
- `ArticleID`, `ContactID`, `VoucherID`, etc.
- Always use typed IDs instead of raw strings/UUIDs

## Dependencies & Integration

### External Dependencies
- **APIToolkit**: Provides base classes and interfaces (`daniel-jorg-schuppelius/php-api-toolkit`)
- **Guzzle**: HTTP client for API communication
- **PSR Log**: Logging interface support

### Error Handling
- Use strict typing (`declare(strict_types=1);`)
- Validate required parameters in endpoint methods
- HTTP responses are handled in `ClientAbstract` with proper exception throwing

## File Conventions
- All files have consistent header comments with author, license, and creation date
- Use PSR-4 autoloading with `Lexoffice\` namespace
- Maintain parallel structure between `src/` and `tests/` directories
- Use descriptive, domain-specific naming (not generic terms)

## Common Anti-Patterns to Avoid
- Don't use raw arrays for structured data - create proper entity classes
- Don't bypass the endpoint interfaces - implement the contracts properly
- Don't ignore rate limiting in the client
- Don't mix entity and resource responsibilities