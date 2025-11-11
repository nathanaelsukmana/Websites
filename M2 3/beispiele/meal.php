<?php
/**
 * Praktikum DBWT. Autoren
 * Nathanael Lumen, Sukmana, 3718553
 * Joshua, Kortyka, 3714612
 */
const GET_PARAM_MIN_STARS = 'search_min_stars';
const GET_PARAM_SEARCH_TEXT = 'search_text';
const GET_PARAM_SHOW_DESCRIPTION = 'show_description';
const GET_PARAM_LANGUAGE = 'sprache';
const GET_PARAM_RATING_FILTER = 'rating_filter';
/**
 * Liste Sprachen
 */
$texts = [
        'de' => [
                'title' => 'Gericht',
                'description' => 'Beschreibung',
                'allergens' => 'Allergene',
                'ratings' => 'Bewertungen',
                'total' => 'Insgesamt',
                'filter' => 'Filter',
                'search' => 'Suchen',
                'author' => 'Autor',
                'stars' => 'Sterne',
                'show' => 'Beschreibung anzeigen',
                'hide' => 'Beschreibung ausblenden',
                'language' => 'Sprache',
                'price_intern' => 'Preis Intern',
                'price_extern' => 'Preis Extern',
                'rating_top' => 'Beste Bewrtung',
                'rating_flopp'=> 'Schlechteste Bewrtung',
                'rating_all' => 'Alle Bewrtungen',
        ],
        'en' => [
                'title' => 'Dish',
                'description' => 'Description',
                'allergens' => 'Allergens',
                'ratings' => 'Ratings',
                'total' => 'Total',
                'filter' => 'Filter',
                'search' => 'Search',
                'author' => 'Author',
                'stars' => 'Stars',
                'show' => 'Show description',
                'hide' => 'Hide description',
                'language' => 'Language',
                'price_intern' => 'Price intern',
                'price_extern' => 'Price extern',
                'rating_top' => 'Best Rating',
                'rating_flopp'=> ' Worst Rating',
                'rating_all' => 'All ratings',
        ]
];
/**
 * List of all allergens.
 */
$allergens = [
    11 => 'Gluten',
    12 => 'Krebstiere',
    13 => 'Eier',
    14 => 'Fisch',
    17 => 'Milch'
];

$meal = [
    'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'price_intern' => 2.90,
    'price_extern' => 3.90,
    'allergens' => [11, 13],
    'amount' => 42             // Number of available meals
];

$ratings = [
    [   'text' => 'Die Kartoffel ist einfach klasse. Nur die Fischstäbchen schmecken nach Käse. ',
        'author' => 'Ute U.',
        'stars' => 2 ],
    [   'text' => 'Sehr gut. Immer wieder gerne',
        'author' => 'Gustav G.',
        'stars' => 4 ],
    [   'text' => 'Der Klassiker für den Wochenstart. Frisch wie immer',
        'author' => 'Renate R.',
        'stars' => 4 ],
    [   'text' => 'Kartoffel ist gut. Das Grüne ist mir suspekt.',
        'author' => 'Marta M.',
        'stars' => 3 ]
];

$showRatings = [];
if (!empty($_GET[GET_PARAM_SEARCH_TEXT])) {
    $searchTerm = $_GET[GET_PARAM_SEARCH_TEXT];
    foreach ($ratings as $rating) {
        if (strpos(strtolower($rating['text']),strtolower($searchTerm)) !== false) {
            $showRatings[] = $rating;
        }
    }
} else if (!empty($_GET[GET_PARAM_MIN_STARS])) {
    $minStars = $_GET[GET_PARAM_MIN_STARS];
    foreach ($ratings as $rating) {
        if ($rating['stars'] >= $minStars) {
            $showRatings[] = $rating;
        }
    }

} else if (!empty($_GET[GET_PARAM_RATING_FILTER])) {
    $filter = strtolower($_GET[GET_PARAM_RATING_FILTER]);
    $allStars = array_column($ratings, 'stars');
    $maxStars = max($allStars);
    $minStars = min($allStars);

    if ($filter === 'top') {
        foreach ($ratings as $rating) {
            if ($rating['stars'] == $maxStars) {
                $showRatings[] = $rating;
            }
        }
    } elseif ($filter === 'flopp') {
        foreach ($ratings as $rating) {
            if ($rating['stars'] == $minStars) {
                $showRatings[] = $rating;
            }
        }
    }
}else {
    $showRatings = $ratings;
}

 function calcMeanStars(array $ratings) : float {
    $sum = 0;
    foreach ($ratings as $rating) {
        $sum += $rating['stars'] ;
    }
    return $sum / count($ratings);
}

$lang = 'de'; // Standard
if (isset($_GET[GET_PARAM_LANGUAGE]) && in_array($_GET[GET_PARAM_LANGUAGE], ['de', 'en'])) {
    $lang = $_GET[GET_PARAM_LANGUAGE];
}
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8"/>
        <title>Gericht: <?php echo $meal['name']; ?></title>
        <style>
            * {
                font-family: Arial, serif;
            }
            .rating {
                color: darkgray;
            }
        </style>
    </head>
    <body>
    <p>
        <?php echo $texts[$lang]['language']; ?>:
        <a href="?sprache=de">Deutsch</a> |
        <a href="?sprache=en">English</a>
    </p>
    <h1><?php echo $texts[$lang]['title']; ?>: <?php echo $meal['name']; ?></h1>
        <p>
            <a href="?show_description=1"><?php echo $texts[$lang]['show']; ?></a> |
            <a href="?show_description=0"><?php echo $texts[$lang]['hide']; ?></a>
        </p>
        <?php
        $showDescription = true;
        if (isset($_GET[GET_PARAM_SHOW_DESCRIPTION]) && $_GET[GET_PARAM_SHOW_DESCRIPTION] == 0) {
            $showDescription = false;
        }

        if ($showDescription) {
            echo "<p>{$meal['description']}</p>";
        }
        ?>

        <h3><?php echo $texts[$lang]['allergens']; ?>:</h3>
        <ul>
            <?php
            foreach ($meal['allergens'] as $id) {
                if (isset($allergens[$id])) {
                    echo "<li>{$allergens[$id]}</li>";
                }
            }
            ?>
            <p>
                <?php echo $texts[$lang]['price_intern'] ?>
                :
                <?php echo number_format($meal['price_intern'], 2, ',','.') ?>
                &#8364
            </p>
            <p>
                <?php echo $texts[$lang]['price_extern'] ?>
                :
                <?php echo number_format($meal['price_extern'], 2, ',','.') ?>
                &#8364
            </p>
        </ul>
        <h1><?php echo $texts[$lang]['total']; ?>: <?php echo calcMeanStars($ratings); ?>)</h1>
    <a href="?rating_filter=Top"><?php echo $texts[$lang]['rating_top']; ?></a> |
    <a href="?rating_filter=Flopp"><?php echo $texts[$lang]['rating_flopp']; ?></a> |
    <a href="?rating_filter=Null"><?php echo $texts[$lang]['rating_all']; ?></a>

        <form method="get">
            <label for="search_text">Filter:</label>
            <input
                    id="search_text"
                    type="text"
                    name="search_text"
                    value="<?php echo isset($_GET[GET_PARAM_SEARCH_TEXT]) ? htmlspecialchars($_GET[GET_PARAM_SEARCH_TEXT]) : ''; ?>"
            >
            <input type="submit" value="<?php echo $texts[$lang]['search']; ?>">
        </form>
        <table class="rating">
            <thead>
            <tr>
                <td>Text</td>
                <td>Author</td>
                <td>Sterne</td>
            </tr>
            </thead>
            <tbody>
            <?php
        foreach ($showRatings as $rating) {
            echo "<tr><td class='rating_text'>{$rating['text']}</td>
                        <td class='rating_text'>{$rating['author']}</td>
                      <td class='rating_stars'>{$rating['stars']}</td>
                  </tr>";
        }
        ?>
            </tbody>
        </table>
    </body>
</html>