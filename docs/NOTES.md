# Dokumentation: Abweichungen zur offiziellen Lexware API

## Postman Collection Korrekturen

### PUT /articles/{id} - Tippfehler korrigiert

**Datum:** 2026-01-11

**Problem:**  
Die offizielle Lexware Postman Collection unter  
`https://developers.lexware.io/assets/public/Lexware-API-Samples.postman_collection.json`  
enthält einen Tippfehler beim PUT-Endpoint für Articles:

- ❌ **Falsch (offiziell):** `PUT /v1/article/{id}` (Singular)
- ✅ **Korrekt:** `PUT /v1/articles/{id}` (Plural)

Alle anderen Article-Endpoints (GET, POST, DELETE, Collection) verwenden korrekt `/articles` (Plural).

**Korrektur:**  
In unserer lokalen Kopie (`docs/lexoffice-API-Samples.postman_collection.json`) wurde der Pfad auf `/articles` korrigiert, um mit der tatsächlichen API und allen anderen Endpoints konsistent zu sein.

**Betroffene Zeilen:**  
- `raw`: `{{resourceurl}}/v1/articles/...` 
- `path`: `["v1", "articles", "..."]`

---

## Widersprüche in der offiziellen Dokumentation

### Kontaktrolle bei Belegen (`vouchers`, `contactId`)

**Datum:** 2026-10-10

Die API-Referenz schreibt zum `contactId` eines Belegs: „If a contact is
assigned to a voucher, its role must either be Customer, or both Customer and
Vendor.“ Das Kochbuch Buchhaltung
(`https://developers.lexware.io/cookbooks/bookkeeping/`) sagt dagegen:
„Ausgaben-Belege können mit Kontakten des Typs Lieferant (Kreditor) oder dem
sogenannten Sammel-Lieferanten verknüpft werden.“ Mehrere unabhängige
Integrationen buchen `purchaseinvoice` an reine `vendor`-Kontakte. Der Satz der
Referenz gilt offenbar nur für Einnahmebelege. Das SDK prüft die Rolle nicht.

### Antwortcode beim Anlegen

**Datum:** 2026-10-10

Die Statuscode-Tabelle nennt `201 Created` für erfolgreiche POST-Anlagen. Bis
v1.2.x erwarteten `VouchersEndpoint::create()` und `ContactsEndpoint::create()`
exakt `200`; eine `201` warf nach erfolgreichem Anlegen eine Ausnahme. Seit
v1.3.0 gelten beide Codes.

### Belegstatus `unchecked`

Seit dem 14.07.2026 lässt sich ein `unchecked`-Beleg per API nur noch nach
`open` überführen (Changelog). Was beim Anlegen fehlt, ergänzt danach nur noch
der Mensch in Lexware.

---

*Diese Datei dokumentiert Abweichungen zwischen der offiziellen Lexware API-Dokumentation und unserer lokalen Kopie.*
