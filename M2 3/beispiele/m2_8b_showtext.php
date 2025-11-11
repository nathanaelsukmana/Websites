<?php

/**
 * Praktikum DBWT. Autoren
 * Nathanael Lumen, Sukmana, 3718553
 * Joshua, Kortyka, 3714612
 */
    //lesen

//ueberpruefung, ob element in post/get ueberhaupt vorhanden ist. ansonsten kommt es zu zugriffsfehler in php
$suchwort = $_GET['suche'] ?? NULL; /* Wenn 'beschreibung' in
                                                    $_POST gesetzt ist, gebe diesen Wert zurück,
                                                    ansonsten NULL. */

if(empty($suchwort)){
    die("Bitte geben Sie eine Suchwort ein.");
}
$file = fopen("en.txt", "r");
if (!$file) {
    die('Öffnen fehlgeschlagen');
}

$gefunden = false;

while (!feof($file)) {      // Solange das Ende der Datei nicht erreicht ist:
    $line = fgets($file);   //lesen

    //fgets() speichert manchmal whitespace im anfang und endesatz
    $nowhitespace = trim($line);

    //von zeile zu array
    $teil = explode(";", $nowhitespace);

        //gibts 2 teile und erste teil passt
    if(count($teil) === 2 && $teil[0] == $suchwort) {

        //uebersetzung zeigen
        echo htmlspecialchars($teil[1]);
        $gefunden = true;
        break;
    }
}

if($gefunden === false) {
    echo "Das gesuchte Wort " . $suchwort . " ist nicht enthalten.";
}

fclose($file);

