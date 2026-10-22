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

### Versandbedingungen am Lieferschein

**Datum:** 2026-10-21

Die Tabelle der Pflichtfelder beim Anlegen nennt `shippingConditions`, die
Eigenschaftsliste und beide Beispiele des Lieferscheins kennen das Feld nicht.
Das SDK sendet es nur, wenn der Aufrufer es setzt. Ein Feld
`deliveryConditions` gibt es nicht; Lieferbedingungen stehen als Text in
`deliveryTerms`.

### Gutschriften ohne Versand und Positionsrabatt

**Datum:** 2026-10-21

Laut Referenz haben Gutschriften im Unterschied zu Rechnungen weder
Fälligkeit noch Versand-, Liefer- und Zahlungsbedingungen noch
Positionsrabatte („Compared to invoices, credit notes do not have …“). Das
SDK modelliert `shippingConditions`, `discountPercentage` und
`closingInvoice` an der Gutschrift deshalb nicht.

### Schreibweise von `electronicDocumentProfile`

**Datum:** 2026-10-21

Die Referenz nennt `NONE`, `EN16931` und `XRechnung` (gemischte
Schreibweise). Das Enum folgt dieser Schreibweise; liefert Lexware einen
anderen Wert (etwa `XRECHNUNG`), bleibt das Feld `null`, der Beleg wird
trotzdem gelesen.

### Belegarten der Belegliste

**Datum:** 2026-10-21

Die Referenz nennt zehn Arten und kündigt weitere an („new voucher types may
be introduced in the future“). `downpaymentdeduction` und `voucher` stehen
nicht in der Referenz; sie sind auf Meldung der workDiary-Anbindung im Enum
`VoucherType` ergänzt.

## SDK-Korrekturen

### `contactId` am Beleg

**Datum:** 2026-10-10

Bis v1.3.0 trug `BaseVoucher::$contactId` die Kontakt-ID mit dem Entity-Namen
`id`; `toArray()`/`toJson()` schrieben deshalb `"contactId": {"id": "…"}` statt
der Zeichenkette, die Lexware erwartet. Seit v1.3.1 nutzt der Beleg
`Lexoffice\Entities\Vouchers\ContactID` (Unterklasse von
`Contacts\ContactID`), `setContactId()` nimmt weiter beide Klassen an.

`Documents\Address::$contactPerson` hatte dieselbe Bauart (Entity-Name
`contactId`). Laut Referenz ist es eine Zeichenkette (Name der Kontaktperson,
nur lesbar); seit v2.0.0 ist es ein `?string`.

### 2.0.0

**Datum:** 2026-10-21

Anlass: Die workDiary-Anbindung führte 19 Lexware-Aufrufe am SDK vorbei, weil
diese Fehler sie verhinderten.

- **IDs sind UUIDs.** Alle ID-Klassen erben von
  `Lexoffice\Contracts\Abstracts\UuidID`; `isValid()` prüft auf UUID
  (`StringHelper::isUuid`, daher common-toolkit `^1.34 || ^2.0`). Bisher
  verlangte `APIToolkit\Entities\ID` eine Zahl: jede Belegadresse mit
  `contactId` war ungültig, Rechnung, Gutschrift, Angebot und AB ließen sich
  so nicht anlegen. Die ID-Klassen setzen ihren Entity-Namen vor der Prüfung
  des Eingangs; `DocumentFileID::fromJson('{"documentFileId": …}')` und damit
  `render()` warfen sonst.
- **Belegadresse.** `Documents\ContactID` erbt wie `Vouchers\ContactID` von
  `Contacts\ContactID`, `Address::setContactId()` nimmt beide an. Das Land
  geht nur hinaus, wenn es angegeben ist (`hasCountryCode()`); die Basisklasse
  des api-toolkit belegt es intern weiter mit DE vor. Eine einmalige Adresse
  ohne `contactId` braucht laut Referenz `name` und `countryCode`.
- **Einzelpreis.** `UnitPrice` sendet nur die gesetzten Beträge; netto bzw.
  brutto leiten die Getter beim Lesen ab, wenn der Steuersatz bekannt ist.
  `taxRatePercentage` hat keine Vorgabe 0 mehr, ebenso `Articles\Price::$taxRate`
  (beide Pflichtfelder laut Referenz). Die Getter liefern `?float`.
- **Lieferschein.** Fehlende `shippingConditions` bleiben leer (bisher
  „service, jetzt“); `getShippingConditions()` liefert `?ShippingConditions`,
  dazu `setShippingConditions()`.
- **E-Rechnungsprofil.** `NamedDocument::getElectronicDocumentProfile()` mit
  Enum `ElectronicDocumentProfile`, nur lesbar.
- **Vorgänger.** `create($data, $precedingSalesVoucherId, $finalize)` sendet
  `precedingSalesVoucherId` für Rechnung, Gutschrift, AB und Lieferschein (wie
  schon bei der Mahnung). `pursue($id, $finalize, $data)` sendet den Beleg;
  ohne `$data` bleibt es beim leeren Body.
- **Dateien.** `downloadContent($id, $accept = '*/*')` liefert `FileContent`
  (Bytes, Medientyp, Dateiname) für `files/{id}` und `/{beleg}/{id}/file`
  (alle Verkaufsbelege samt Abschlagsrechnung). `FilesEndpoint::download()`
  schreibt weiter in ein Verzeichnis, sendet aber `Accept: */*` statt
  `application/json`. `render()` (`/document`) ist laut Referenz veraltet.
- **Buchungsbeleg.** `Vouchers\Voucher::$files` ist `FileIDs` (Liste von
  UUIDs) statt `Files`; ein PUT schreibt die Liste unverändert zurück.
- **Tolerante Enums.** Lesende Felder, die Lexware erweitert, sind nullbar:
  ein unbekannter Wert wird `null` (api-toolkit ≥ 2.7), statt die Seite
  scheitern zu lassen: `VoucherList\Voucher::$voucherType`,
  `PaymentItem::$paymentItemType`, `EventSubscription::$eventType`,
  `electronicDocumentProfile`. Die Getter liefern nullbare Typen.
- **Enum-Werte.** `VoucherType`: `orderconfirmation`, `quotation`,
  `deliverynote` (Referenz) sowie `downpaymentdeduction`, `voucher`;
  `PaymentItemType::IRRECOVERABLERECEIVABLE`;
  `EventType::DELIVERY_NOTE_STATUS_CHANGED`; `VoucherStatus::BLANK`.
- **Weitere Nullwerte laut Referenz.** `VoucherList\Voucher::$openAmount`
  (z. B. Entwürfe) und `Payment::$paidDate` (nur bei bezahlten Belegen).

---

*Diese Datei dokumentiert Abweichungen zwischen der offiziellen Lexware API-Dokumentation und unserer lokalen Kopie.*
