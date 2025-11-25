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

    $link = mysqli_connect("localhost", "root", "", "emensawerbeseite");

    if (!$link) {
        echo("DB-Verbindungsfehler: " . mysqli_connect_error());
    }

    $name = $_POST['vorname'] ?? '';
    $email = $_POST['mail'] ?? '';
    $sprache = $_POST['sprache'] ?? 'deutsch';
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
        // Sicheres Escaping
        $nameEsc = mysqli_real_escape_string($link, trim($name));
        $emailEsc = mysqli_real_escape_string($link, strtolower(trim($email)));
        $spracheEsc = mysqli_real_escape_string($link, $sprache);

        // Datensatz speichern
        $sql_newsletter = "INSERT INTO newsletter (vorname, email, sprache) VALUES ('$nameEsc', '$emailEsc', '$spracheEsc');";

        if (mysqli_query($link, $sql_newsletter)) {
            $meldung = "<p style='color:green;'>Vielen Dank, {$nameEsc}! Ihre Anmeldung zum Newsletter war erfolgreich.</p>";
        } else {
            $meldung = "<p style='color:red;'>Fehler bei der Speicherung in der Datenbank: "
                . htmlspecialchars(mysqli_error($link)) . "</p>";
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