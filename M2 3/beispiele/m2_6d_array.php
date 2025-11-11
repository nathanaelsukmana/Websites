<!-- html, php array und konvertierung, css -->

<html>
    <title>Famous Meals</title>
    <style>
        /* aussenabstand zwischen list */
        li {
            margin-bottom: 5px;
        }
    </style>
<?php
/**
 * Praktikum DBWT. Autoren:
 * Nathanael Lumen, Sukmana, 3718553
 * Joshua, Kortyka, 3714612
 */

//array von der aufgabe
$famousMeals = [
    1 => ['name' => 'Currywurst mit Pommes',
        'winner' => [2001, 2003, 2007, 2010, 2020]],
    2 => ['name' => 'Hähnchencrossies mit Paprikareis',
        'winner' => [2002, 2004, 2008]],
    3 => ['name' => 'Spaghetti Bolognese',
        'winner' => [2011, 2012, 2017]],
    4 => ['name' => 'Jägerschnitzel mit Pommes',
        'winner' => [2019]]
];

//liste ausgabe
echo '<ol>';

        function fehlendeJahre($meals){
            $jahreInListe = [];

            //jedes meal
            foreach ($meals as $key => $meal) {

                //jedes jahr
                foreach ($meal['winner'] as $jahr) {
                    //jahre ins array hinzufuegen
                    $jahreInListe[] = $jahr;
                }
            }

            $alleJahre = [];

            $jetztigesJahr = 2025;
                    //wie in aufg
            for($i = 2000; $i <= $jetztigesJahr; $i++){
                $alleJahre[] = $i;
            }

            //fehlende jahre
            $result = [];
            foreach ($alleJahre as $key => $jahr) {
                if(array_search($jahr, $jahreInListe) === FALSE){
                    $result[] = $jahr;
                }
            }

            return $result;
        }
                        //index, value; immer in for each
foreach ($famousMeals as $key => $meal) {
    echo '<li>';
    echo $meal['name'];

    //reverse sort: descending order
    rsort($meal['winner']);
    //Konvertierung array zu string
    $winnerstring = implode(', ', $meal['winner']);

    echo '<br>'.$winnerstring;

    echo '</li>';
}

        //fkt aufr
        $jahreOhneGewinner = fehlendeJahre($famousMeals);
        echo 'Jahre ab 2000 bis heute keine Gewinner existieren: ';
        echo implode(', ', $jahreOhneGewinner);
?>
</html>

