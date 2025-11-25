
<?php


$link=mysqli_connect("localhost",
    "root",
    "",
    "emensawerbeseite"
);

if(!$link){
    echo "Verbindungsfehler:", mysqli_connect_error();
    exit();
}
$sql = "SELECT id, name, beschreibung FROM emensawerbeseite.gericht";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "Fehler: " . mysqli_error($link);
    exit();
}

while($row = mysqli_fetch_assoc($result)){
    echo '<li>'.'ID: ' . $row["id"] . ' ,Name: ' . $row["name"] .' ,Beschreibung: '. $row["beschreibung"] .'</li>';

}