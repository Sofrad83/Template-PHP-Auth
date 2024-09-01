<?php

namespace Core;

use Core\Database\DatabaseConfig;
use Core\Database\DatabaseConnection;
use Core\Database\DatabaseQuery;
use Exception;

class DB
{
    private static $queryBuilder;

    // Initialisation du QueryBuilder
    private static function init()
    {
        if (self::$queryBuilder === null) {
            // Création de la configuration
            $config = new DatabaseConfig();
            
            // Création de la connexion avec la configuration
            $connection = new DatabaseConnection($config);
            
            // Initialisation du QueryBuilder avec la connexion PDO
            self::$queryBuilder = new DatabaseQuery($connection->getPdo());
        }
    }

    // Méthode statique pour exécuter une requête SQL SELECT
    public static function select($sql, $params = [])
    {
        self::init();
        
        try {
            return self::$queryBuilder->query($sql, $params);
        } catch (Exception $e) {
            die("Erreur lors de la requête SELECT : " . $e->getMessage());
        }
    }

    // Méthode statique pour exécuter une requête SQL INSERT, UPDATE ou DELETE
    public static function execute($sql, $params = [])
    {
        self::init();

        try {
            return self::$queryBuilder->execute($sql, $params);
        } catch (Exception $e) {
            die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        }
    }
}
