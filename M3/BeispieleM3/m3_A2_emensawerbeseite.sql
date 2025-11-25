create database if not exists emensawerbeseite;

use emensawerbeseite;

create table if not exists `gericht`
(
    `id`           int8,                                                      -- Primärschlüssel
    `name`         varchar(80)  not null unique,                              -- Name des gerichtes. Ein Name ist eindeutig
    `beschreibung` varchar(800) not null,                                     -- Beschreibung des Gerichtes
    `erfasst_am`   date         not null,                                     -- Zeitpunkt der Erfassung des gerichtes
    `vegetarisch`  boolean      not null,                                     -- Markierung, ob das Gericht vegetarisch ist.Standart:Nein
    `vegan`        boolean      not null,                                     -- Markierung, ob das Gericht vegan ist.Standart:Nein
    `preisintern`  double       not null,                                     -- Preis für interne personen(wie Studierende).Es gilt immer preisintern>0
    `preisextern`  double       not null check ( preisintern < preisextern ), -- Preis für externe personen( wie Gastdozent:innen)
    primary key (id)


    );

create table if not exists `allergen`
(
    `code` char(4),               -- Offizieller Abkürzungsbuchstabe dür das Allergen
    `name` varchar(300) not null, -- Name des Allergens, wie "Glutenhaltiges Getreide"
    `typ`  varchar(20)  not null, -- Gibt den Typ an. Standart "allergen"
    primary key (code)
    );

create table if not exists `kategorie`
(
    `id`        int8,                 -- Primärschlüssel
    `name`      varchar(80) not null, -- Name der Kategorie, z.B. "Hauptgericht","Salat", "Sauce" oder "Käsegericht"
    `eltern_id` int8,                 -- Refferenz auf eine (Eltern-)Katerogie. Es soll eine Baumstruktur innerhalb der kategorien abgebildet werden. Zum beispiel enthält die kategorie „Hauptgericht“ alle Kategorien, denen Gerichte zugeordnet sind, die als Hauptgang vorgesehen sind.
    `bildname`  varchar(80),          -- Name der Bilddatei, die eine Darstellung der Kategorie enthällt
    primary key (id)
    );

create table if not exists `gericht_hat_allergen`
(
    `code`       char(4),      -- referenz auf Allergen
    `gericht_id` int8 not null,-- Refferenz auf das gericht
    FOREIGN KEY (code) REFERENCES allergen (code),
    FOREIGN KEY (gericht_id) REFERENCES gericht (id)

    );

create table if not exists `gericht_hat_kategorie`
(
    `gericht_id`   int8 not null, -- Referenz auf Gericht
    `kategorie_id` int8 not null, -- Referenz auf Kategorie
    FOREIGN KEY (gericht_id) REFERENCES gericht (id),
    FOREIGN KEY (kategorie_id) REFERENCES kategorie(id)
    );

create table if not exists besucherzahl(
                                               anzahl int8,
                                               PRIMARY KEY(anzahl)
)

CREATE TABLE newsletter (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            vorname VARCHAR(100) NOT NULL,
                            email VARCHAR(200) NOT NULL,
                            sprache VARCHAR(50) NOT NULL,
                            zeitpunkt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

insert into emensawerbeseite.besucherzahl(anzahl) VALUES
    (
        0
    )
