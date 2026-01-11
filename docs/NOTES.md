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

*Diese Datei dokumentiert Abweichungen zwischen der offiziellen Lexware API-Dokumentation und unserer lokalen Kopie.*
