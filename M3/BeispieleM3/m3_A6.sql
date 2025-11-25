-- A6
-- 1)
SELECT
    g.name AS gericht_name,
    GROUP_CONCAT(a.name ORDER BY a.name SEPARATOR ', ' ) AS allergene
FROM gericht_hat_allergen gha
         LEFT JOIN gericht g
                   ON gha.gericht_id = g.id
         LEFT JOIN allergen a
                   ON gha.code = a.code
GROUP BY g.id, g.name
ORDER BY g.name;
-- 2)
SELECT
    g.name AS gericht_name,
    GROUP_CONCAT(a.name ORDER BY a.name SEPARATOR ', ' ) AS allergene
FROM gericht g
         LEFT JOIN gericht_hat_allergen gha
                   ON gha.gericht_id = g.id
         LEFT JOIN allergen a
                   ON gha.code = a.code
GROUP BY g.id, g.name
ORDER BY g.name;
-- 3)
SELECT
    a.name AS allergen_name,
    GROUP_CONCAT(g.name ORDER BY g.name SEPARATOR ', ') AS gerichte
FROM allergen a
         LEFT JOIN gericht_hat_allergen gha
                   ON a.code = gha.code
         LEFT JOIN gericht g
                   ON gha.gericht_id = g.id
GROUP BY a.code, a.name
ORDER BY a.name;
-- 4)
SELECT
    k.name AS kategorie_name,
    COUNT(ghk.gericht_id) AS anzahl_gerichte
FROM kategorie k
         LEFT JOIN gericht_hat_kategorie ghk
                   ON k.id = ghk.kategorie_id
GROUP BY k.id, k.name
ORDER BY anzahl_gerichte ASC;
-- 5)
SELECT
    k.name AS kategorie_name,
    COUNT(ghk.gericht_id) AS anzahl_gerichte
FROM kategorie k
         LEFT JOIN gericht_hat_kategorie ghk
                   ON k.id = ghk.kategorie_id
GROUP BY k.id, k.name
HAVING COUNT(ghk.gericht_id) > 2
ORDER BY anzahl_gerichte ASC;
