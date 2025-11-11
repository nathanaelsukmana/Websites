<?php global $gerichte;
/**
* Joshua, Kortyka, 3714612
* Nathanael Lumen, Sukmana, 3718553
*/
include('gerichte.php');
include ('Newsletter.php');

//AUFGABE 10.1
$counter = 'counter.txt';
$zahl = 0;

$read = fopen($counter, "r");

//if datei vorhanden ist und geoeffnet ist
if($read){
    $erstezeile = fgets($read);
    $zahl = (int)$erstezeile;
    fclose($read);
}

$zahl = $zahl + 1;
                                //oeffne datei zum schreiben und erzeugt eine neue datei
$read = fopen($counter, "w");

if(!$read){
    die('Error');
}

        //neue zahl schreiben
fwrite($read, $zahl);
fclose($read);

//AUFGABE 10.2
$anzahlGerichte = count($gerichte);

//AUFGABE 10.3
$anmeldungen = 'newsletter_anmeldungen.txt';
$anmeldungCounter = 0;

$readA = fopen($anmeldungen, "r");
if(!$readA){
    die('Error');
}
if($readA){
    //solange das ende der datei nicht erreicht ist
    while(!feof($readA)){
        $zeile = fgets($readA);

                    //wenn die zeile nicht leer ist, whitespace trim
        if(!empty(trim($zeile))){
            $anmeldungCounter++;
        }
    }
}

fclose($readA);

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
<header>
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
    <div id="Ankuendigung" class="info">
            <h1>Bald gibt es Essen auch online ;)</h1>
            <p class="texte">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut finibus, ex sed efficitur tincidunt, libero purus feugiat magna, quis dictum sem nisi at erat. Mauris convallis nisi quis elit ullamcorper, vel sollicitudin risus semper. Cras in tincidunt nisi, nec tincidunt felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec et tellus vel nisi vehicula suscipit. Fusce eleifend felis et mi facilisis, vel bibendum sapien eleifend. In hac habitasse platea dictumst.
            </p>
    </div>

    <div id="Menu" class="menu">
        <h1 >Köstlichkeiten, die Sie erwarten</h1>
        <table>
            <thead>
                <tr>
                    <th>Bild</th>
                    <th>Gericht</th>
                    <th>Preis intern</th>
                    <th>Preis extern</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($gerichte as $gericht): ?>
                <tr>
                    <td>
                        <img src="img/<?php echo $gericht['bild']; ?>" alt="<?php echo htmlspecialchars($gericht['name']); ?>" width="120">
                    </td>
                    <td><?php echo htmlspecialchars($gericht['name']); ?></td>
                    <td><?php echo number_format($gericht['preis_intern'], 2, ',', '.'); ?></td>
                    <td><?php echo number_format($gericht['preis_extern'], 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="Zahlen" class="info">
        <h1>E-Mensa in Zahlen</h1>
        <h2 class="zentrum">
            <strong><?php echo $zahl . ' '?>Besuche &ensp;  &ensp; <?php echo $anmeldungCounter . ' ' ?> zum Newsletter &ensp;  &ensp;<?php echo $anzahlGerichte . " " ?>Speisen</strong>
        </h2>
    </div>

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
    <hr class="margintop">
    <div class="fussnote">
        (c) E-Mensa GmbH &ensp; |&ensp; Nathanael Lumen Sukmana,Joshua Kortyka &ensp;|&ensp;
        <a href="#" class="links"> Impressum</a>

    </div>
</main>
</div>
</body>
</html>
