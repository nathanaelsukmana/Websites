<?php

/**
 * Praktikum DBWT. Autoren
 * Nathanael Lumen, Sukmana, 3718553
 * Joshua, Kortyka, 3714612
 */

// Pfad zur Datendatei
$dataFile ='newsletter_anmeldungen.txt';

// Hilfsfunktion zur Überprüfung, ob eine Zeichenkette nur aus Leerzeichen besteht
function isBlank($str) {
    return strlen(trim($str)) === 0;
}

// Funktion zur Überprüfung auf Wegwerf-Mail-Anbieter
function isDisposableMail($email) {
    $forbiddenDomains = ['wegwerfmail.de', 'trashmail.de', 'trashmail.com', 'trashmail.net'];
    $domain = strtolower(substr(strrchr($email, "@"), 1));
    foreach ($forbiddenDomains as $forbidden) {
        if ($domain === $forbidden) {
            return true;
        }
    }
    return false;
}

// Wenn Formular abgesendet wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['vorname'] ?? '';
    $email = $_POST['mail'] ?? '';
    $datenschutz = isset($_POST['datenschutz']);

    $fehler = [];

    // 1. Name darf nicht leer oder nur Leerzeichen sein
    if (isBlank($name)) {
        $fehler[] = "Bitte geben Sie einen gültigen Namen ein.";
    }

    // 2. Datenschutz muss akzeptiert sein
    if (!$datenschutz) {
        $fehler[] = "Bitte stimmen Sie den Datenschutzbestimmungen zu.";
    }

    // 3. E-Mail-Format prüfen
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $fehler[] = "Ihre E-Mail entspricht nicht den Vorgaben.";
    }

    // 4. Wegwerf-Mail prüfen
    if (isDisposableMail($email)) {
        $fehler[] = "E-Mail-Adressen von Wegwerfmail-Diensten sind nicht erlaubt.";
    }

    // Wenn keine Fehler: speichern
    if (empty($fehler)) {
        try {
            $datenzeile = [
                'name' => trim($name),
                'email' => strtolower(trim($email))
            ];

            // Falls Datei noch nicht existiert → Kopfzeile hinzufügen
            $neueDatei = !file_exists($dataFile);



            $handle = fopen($dataFile, 'a');
            if ($handle === false) {
                throw new Exception("Datei konnte nicht geöffnet werden.");
            }

            if ($neueDatei) {
                // Kopfzeile schreiben (Feldnamen)
                fwrite($handle, "name;email\n");

                }

            // Datensatz schreiben

               $line = "{$datenzeile['name']};{$datenzeile['email']}\n";
               fwrite($handle, $line);

            // Erfolgsnachricht
            $meldung = "<p style='color:green;'>Vielen Dank, {$name}! Ihre Anmeldung zum Newsletter war erfolgreich.</p>";

        } catch (Exception $e) {
            $meldung = "<p style='color:red;'>Fehler beim Speichern der Daten: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        // Fehler ausgeben
        $meldung = "<ul style='color:red;'>";
        foreach ($fehler as $f) {
            $meldung .= "<li>" . htmlspecialchars($f) . "</li>";
        }
        $meldung .= "</ul>";
    }
}
?>