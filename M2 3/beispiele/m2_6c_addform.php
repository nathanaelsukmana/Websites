<?php
/**
* Praktikum DBWT. Autoren:
* Nathanael Lumen, Sukmana, 3718553
* Joshua, Kortyka, 3714612
*/
include('m2_6a_standardparamater.php');

$result = NULL;
if(isset($_POST['addieren'])){
    //daten nehmen
    $a = (int)$_POST['a'];
    $b = (int)$_POST['b'];

    $result = addieren($a,$b);

} else if(isset($_POST['multiplizieren'])){
    $a = (int)$_POST['a'];
    $b = (int)$_POST['b'];
    $result = $a * $b;
}


?>


<head><title>Formular</title></head>
                <!-- daten unabhaengig von url -->
<form action="" method="post">
    <fieldset>
                <!-- name, damit php kann mit isset() pruefen -->
    <input type="text" name="a" placeholder="a">
    <br><br>
    <input type="text" name="b" placeholder="b">
    <br><br>
    <input type="submit" name="addieren" value="Addieren">
    <input type="submit" name="multiplizieren" value="Multiplizieren">
    </fieldset>
</form>

<?php echo $result ?>






