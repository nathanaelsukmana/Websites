<?php
/**
 * Praktikum DBWT. Autoren
 * Nathanael Lumen, Sukmana, 3718553
 * Joshua, Kortyka, 3714612
 */

//jedes mal ein person diese file in browser oeffnet, diese file muss log in accesslog.txt schreiben

    //infos vorbereiten
                    //datum uhrzeit
    $date = date("Y-m-d H:i:s");

                            //ip client
    $ipaddresse = $_SERVER['REMOTE_ADDR'];

                        //browser info
    $browser = $_SERVER['HTTP_USER_AGENT'];

    $log = $date." - IP Addresse: ".$ipaddresse." - Browser: ".$browser."\n";

//oeffne eine datei zum schreiben oder lesen, append schreiben in letztes teil von datei
$offnen = fopen('./accesslog.txt', 'a');

//string schreiben in die datei
fwrite($offnen, $log);

//schliesst eine geoeffnete resource, ansonsten kann error
fclose($offnen);

echo 'Log wurde erfolgreich geschrieben';
