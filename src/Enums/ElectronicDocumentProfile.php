<?php
/*
 * Created on   : Wed Oct 21 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ElectronicDocumentProfile.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Enums;

/**
 * E-Rechnungsprofil eines Verkaufsbelegs (nur lesbar, seit 13.01.2025).
 * Schreibweise der Werte laut API-Referenz.
 */
enum ElectronicDocumentProfile: string {
    case NONE = 'NONE';
    case EN16931 = 'EN16931';
    case XRECHNUNG = 'XRechnung';
}
