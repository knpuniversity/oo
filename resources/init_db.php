<?php

/*
 * SETTINGS!
 */
$databaseName = 'oo_battle';
$databaseUser = 'root';
$databasePassword = '';

/*
 * CREATE THE DATABASE
 */
$pdoDatabase = new PDO('mysql:host=localhost', $databaseUser, $databasePassword);
$pdoDatabase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdoDatabase->exec('CREATE DATABASE IF NOT EXISTS oo_battle');

/*
 * CREATE THE TABLE
 */
$pdo = new PDO('mysql:host=localhost;dbname='.$databaseName, $databaseUser, $databasePassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// initialize the table
$pdo->exec('DROP TABLE IF EXISTS ship;');

$pdo->exec('CREATE TABLE `ship` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `weapon_power` int(4) NOT NULL,
 `jedi_factor` int(4) NOT NULL,
 `strength` int(4) NOT NULL,
 `is_under_repair` tinyint(1) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

/*
 * INSERT SOME DATA!
 */
$pdo->exec('INSERT INTO ship
    (name, weapon_power, jedi_factor, strength, is_under_repair) VALUES
    ("Jedi Starfighter", 5, 15, 30, 0)'
);
$pdo->exec('INSERT INTO ship
    (name, weapon_power, jedi_factor, strength, is_under_repair) VALUES
    ("CloakShape Fighter", 2, 2, 70, 0)'
);
$pdo->exec('INSERT INTO ship
    (name, weapon_power, jedi_factor, strength, is_under_repair) VALUES
    ("Super Star Destroyer", 70, 0, 500, 0)'
);
$pdo->exec('INSERT INTO ship
    (name, weapon_power, jedi_factor, strength, is_under_repair) VALUES
    ("RZ-1 A-wing interceptor", 4, 4, 50, 0)'
);

echo 'Ding!';
