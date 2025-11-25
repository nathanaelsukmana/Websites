<?php global $gerichte;
/**
* Joshua, Kortyka, 3714612
* Nathanael Lumen, Sukmana, 3718553
*/
include('gerichte.php');
include ('Newsletter.php');

// verbindung mit der Datenbank
$link=mysqli_connect("localhost",
        "root",
        "",
        "emensawerbeseite"
);

if(!$link){
    echo "Verbindungsfehler:", mysqli_connect_error();
    exit();
}

//AUFGABE 5.2
$sortierung = 'ASC'; // setzt default: A-Z sort auf aufsteigend

if (isset($_GET['sort']) && $_GET['sort'] == 'desc') { //5.2 ob sort mit wert desc uebergeben wuerde, abfrage der tabelleninhalte
    $sortierung = 'DESC'; //wenn ja, die s var auf desc gesetzt
}

//AUFGABE 5.1 & id fuer AUFGABE 5.3 -> PHP Datenbankbindung mit mysqli.pdf
//Daten abfragen aka mengakses || select = daten holen, order by name = sortieren, limit = begrenzen
    $sql = "select id, name, preisintern, preisextern from gericht order by name $sortierung limit 5"; //s var wird in sql befehl eingebaut
    $result = mysqli_query($link, $sql); //perintah sql ke server database mariadb, ohne diese fkt, vorherige codezeile nur normal text sodass wird nicht durchgefuehrt

//Ergebnisse aufbereiten
    //nimmt ergebnis in array
    $gerichte = [];
    while ($row = mysqli_fetch_assoc($result)) { //5.1 assoc = arrayschluessel sind die feldnamen

        //query fuer spezifische allergen von diesem gericht
        $id = $row['id'];
        $sql_allergene = "select code from gericht_hat_allergen where gericht_id=$id";
        $res_allergene = mysqli_query($link, $sql_allergene); //$welche serverziel von dieser befehl, %teilt database was sollte er machen mit

        //allergen code ins string
        $code_allergene = [];
        while ($a = mysqli_fetch_assoc($res_allergene)) {
            $code_allergene[] = $a['code'];
        }
        $row['allergene'] = implode(",", $code_allergene);
        $gerichte[] = $row; //5.1 speichert die zeile ins array
    }

    $sql_legende="select code,name from allergen order by code";
    $res_legende = mysqli_query($link, $sql_legende);
//9.1
$sql_gericht_count = "SELECT count(*) AS anzahl FROM emensawerbeseite.gericht"; //aggregatfkt = count(*) fuer anzahl der ZEILEN in tabelle
$result_gericht_Count = mysqli_query($link, $sql_gericht_count);

if(!$result_gericht_Count){
    echo "Fehler: " . mysqli_error($link);
    exit();
}

//holt das ergebnis und speichert die zahl in gc
$row_gericht_count = mysqli_fetch_assoc($result_gericht_Count);
$gericht_Count = $row_gericht_count['anzahl'];

//M3 A9 2) -- Newsletteranmeldungen anzahl aus datenbank holen
$sql_news = "SELECT COUNT(id) AS anzahl FROM newsletter";
$res_news = mysqli_query($link, $sql_news);
$row_news = mysqli_fetch_assoc($res_news);
$newsletteranmeldung_Counter = $row_news['anzahl'];


//M3 A9 3) -- bei besuchen der Seite besucherzahl in datenbank um 1 erhöhen und aus Datenbank ziehen
$sql_besucheranzahl_update= "UPDATE emensawerbeseite.besucherzahl SET anzahl=anzahl + 1";
mysqli_query($link, $sql_besucheranzahl_update);

$sql_besucheranzahl = "SELECT anzahl FROM emensawerbeseite.besucherzahl";
$result_besucheranzahl = mysqli_query($link, $sql_besucheranzahl);
if(!$result_besucheranzahl){
    echo "Fehler: " . mysqli_error($link);
    exit();
}
$row_besucheranzahl = mysqli_fetch_assoc($result_besucheranzahl);
$besucheranzahl = $row_besucheranzahl['anzahl'];


?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Ihre E-Mensa</title>
    <style>
        * {
            margin: 0 ;
            padding: 0;
            font-family: "Comic Sans MS", sans-serif;
        }
        .frame{
            border: 1px solid black;
            padding: 2px;


        }
        body {
            display: flex;
            background: white;
            color: black;
            padding: 20px;
            border: 1px solid black;

        }
        header {
            display: flex;
            justify-content: left;
            padding: 10px 10px;
            gap: 45px;

        }
        main{
            justify-self: center;
            width: 70%;


        }
        .logo {
            border: 1px solid black;
            padding: 10px 10px;
            font-weight: bold;
        }

        links {
            display: flex;
            gap: 15px;
            justify-self: center;
        }

        links a {
            color: teal;
            padding: 8px 15px;

        }

        .info {
            margin-top: 40px;
            text-align: left;
        }
        .platzhalter {
            border: 1px solid black;
            height: 200px;
            margin: 0 auto 20px;
        }

        .texte {
            border: 2px solid black;
            padding: 10px;

        }

        .menu {
            margin-top: 40px;
            width: 100%;
        }

        .menu table {
            justify-self: center;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .menu th, .menu td {
            border: 2px solid black;
            padding: 10px;
            text-align: left;
        }

        .menu th {
            background: beige;
        }

        .zentrum {
            margin-top: 40px;
            text-align:left;
            justify-self: center;
        }


        .margintop{
            margin-top: 10px;
        }

        .newsleter{
            margin-top: 10px;
            list-style: none;
            display: grid;
            grid-template-columns: repeat(3,220px);
            gap: 10px;
        }

        .fussnote{
            margin: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="frame">
<header>  <!--Kopfzeile der Werbeseite -->
    <div class="logo">E-Mensa Logo</div>
    <div class="frame">
        <a href="#Ankuendigung">Ankündigung</a>
        <a href="#Menu">Speisen</a>
        <a href="#Zahlen">Zahlen</a>
        <a href="#Kontakt">Kontakt</a>
        <a href="#Wichtig">Wichtig für uns</a>
    </div>
</header>

<hr class="margintop" >
<main>
    <div>
        <div class="platzhalter"></div>
    </div>
    <!--Ankündigungsfenster -->
    <div id="Ankuendigung" class="info">
            <h1>Bald gibt es Essen auch online ;)</h1>
            <p class="texte">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut finibus, ex sed efficitur tincidunt, libero purus feugiat magna, quis dictum sem nisi at erat. Mauris convallis nisi quis elit ullamcorper, vel sollicitudin risus semper. Cras in tincidunt nisi, nec tincidunt felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec et tellus vel nisi vehicula suscipit. Fusce eleifend felis et mi facilisis, vel bibendum sapien eleifend. In hac habitasse platea dictumst.
            </p>
    </div>
    <!--Menütabelle -->
    <div id="Menu" class="menu">
        <h1 >Köstlichkeiten, die Sie erwarten</h1>
        <!-- 5.2 -->
        <p>Sortieren nach Name:
            <a href="?sort=asc">Aufsteigend (A-Z)</a>
            <a href="?sort=desc">Absteigend (Z-A)</a>
        </p>
        <table>
            <thead>
                <tr>
                 <!--   <th>Bild</th> -->
                    <th>Gericht</th>
                    <th>Preis intern</th>
                    <th>Preis extern</th>
                    <th>Allergen</th>
                </tr>
            </thead>
            <tbody>
            <!-- 5. 1 Ausgabe der Gerichte aus gerichte.php in Tabelle -->
            <?php foreach ($gerichte as $gericht): ?>
                <tr>
                   <!-- <td> -->
                       <!-- <img src="img/<-- ?php echo $gericht['bild']; ?>" alt="<-- ?php echo htmlspecialchars($gericht['name']); ?>" width="120"-->
                   <!-- </td> -->
                    <td><?php echo htmlspecialchars($gericht['name']); ?></td> <!-- 5.1 zeigt den namen -->
                    <td><?php echo number_format($gericht['preisintern'], 2, ',', '.'); ?></td>
                    <td><?php echo number_format($gericht['preisextern'], 2, ',', '.'); ?></td>
                    <!-- 5.3 -->
                    <td><?php echo $gericht['allergene']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!--Angabe der Besucherzahlen,Newsletteranmeldungen und Gerichteeanzahl -->
    <div id="Zahlen" class="info">
        <h1>E-Mensa in Zahlen</h1>
        <h2 class="zentrum">
            <strong>
                <?php echo $besucheranzahl . ' '?>Besuche &ensp;  &ensp;
                <!-- 9.2 -->
                <?php echo $newsletteranmeldung_Counter . ' ' ?> zum Newsletter &ensp;  &ensp;
                <!-- 9.1 -->
                <?php echo $gericht_Count . ' '  ?> Speisen</strong>
        </h2>
    </div>
    <!--Newsletteranmeldung -->
    <div id="Kontakt" class="info">
        <h1> Interesse geweckt? Wir informieren Sie!</h1>
        <br>

        <form method="post">
            <div class="newsleter">
                <label for="vorname">Ihr Name:</label>
                <label for="mail">Ihre E-Mail: </label>
                <label for="sprache">Newsletter bitte in:</label>
                <input type="text" id="vorname" name="vorname" size="9" value="<?= htmlspecialchars($_POST['vorname'] ?? '') ?>" required>
                <input type="email" id="mail" name="mail" size="9" value="<?= htmlspecialchars($_POST['mail'] ?? '') ?>" required>
                <select id="sprache" name="sprache" >
                    <option value="deutsch">Deutsch</option>
                    <option value="englisch">English</option>
                </select>
            </div>
            <div class="margintop">
                <input type="checkbox" id="datenschutz" name="datenschutz" value="<?= isset($_POST['datenschutz']) ? 'checked' : '' ?>" required>
                <label for="datenschutz">Den Datenschutzbestimmungen stimme ich zu&ensp;</label>
                <button type="submit" id="button" name="button"> Newsletter anmelden </button>
            </div>
            <?php if (isset($meldung)) echo $meldung; ?>
        </form>
    </div>

    <!--Darstellung wichtiger Faktoren -->
    <div id="Wichtig" class="info">
        <h1>Das ist uns wichtig</h1>
        <div class="zentrum">
            <ul class="zentrum">
                <li>Beste frische Saisonale Zutaten</li>
                <li>Ausgewogene abwechslungsreiche Gerichte</li>
                <li>Sauberkeit</li>
            </ul>
        </div>
    </div>

    <div class="zentrum">
        <h1>Wir freuen uns auf Ihren Besuch</h1>
    </div>

    <!--Fußzeile -->
    <hr class="margintop">
    <div class="fussnote">
        (c) E-Mensa GmbH &ensp; |&ensp; Nathanael Lumen Sukmana,Joshua Kortyka &ensp;|&ensp;
        <a href="#" class="links"> Impressum</a>

    </div>
    <div id="Allergene" class="info">
        <h3>Verwendete Allergene</h3>
        <ul>
            <?php while ($a = mysqli_fetch_assoc($res_legende)): ?>
                <li><strong><?php echo $a['code']; ?>:</strong> <?php echo $a['name']; ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
</main>
</div>
</body>
</html>
