<?php
//wie in connection_example.php in gitlab
$link = mysqli_connect("localhost", "root",
    "", "emensawerbeseite", 3306);

if (!$link) {
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}
