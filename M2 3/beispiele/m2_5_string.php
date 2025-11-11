<?php

/**
 * Praktikum DBWT. Autoren
 * Nathanael Lumen, Sukmana, 3718553
 * Joshua, Kortyka, 3714612
 */

echo "<h4>a) str_replace</h4>";
$text = "Hallo Welt";
$neuText = str_replace("Hallo","Tschö",$text);
echo "Vorher: $text <br>";
echo "Nachher: $neuText<br>";

echo "<h4>b) str_repeat</h4>";
$wiederholung = str_repeat($text,3);
echo "$wiederholung <br>";

echo "<h4>c) substr</h4>";
$Wort ="123456789";
$teil =substr($Wort,3,3);
echo "Vorher: $Wort <br>";
echo "Nachher: $teil <br>";

echo "<h4>d) trim</h4>";
$Wort2 = "  Hallo Welt  ";
$WortTrimmed = trim($Wort2);
$WortLtrimmed = ltrim($Wort2);
$WortRtrimmed = rtrim($Wort2);
echo "Vorher:> $Wort2 <<br>";
echo "trim :>$WortTrimmed< <br>";
echo "ltrim :>$WortLtrimmed< <br>";
echo "rtrim :>$WortRtrimmed< <br>";

echo "<h4>e) String-Konkatenation</h4><br>";
$vorname = "Max";
$nachname = "Mustermann";
$vollerName = $vorname." ".$nachname;
echo "Vollständiger Name: $vollerName <br>";


