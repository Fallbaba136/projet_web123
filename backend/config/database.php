<?php
/**
 * Ce script établit une connexion à une base de données MySQL en utilisant PDO (PHP Data Objects).
 * Il configure les paramètres de connexion, tels que l'hôte, le port, le nom de la base de données, le charset, ainsi que les identifiants de connexion (nom d'utilisateur et mot de passe).
 * Ensuite, il crée une instance de PDO pour se connecter à la base de données et configure l'attribut d'erreur pour lancer des exceptions en cas de problème de connexion ou d'exécution de requêtes SQL.
 */
$pdo = new PDO(
    "mysql:host=127.0.0.1;port=3306;dbname=recipe_db;charset=utf8",
    "root",
    "Bbff2030"
);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);