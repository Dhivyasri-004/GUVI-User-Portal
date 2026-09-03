
<?php

require_once __DIR__ . "/config.php";

function getMySQLConnection()
{
    try {

        $dsn = "mysql:host=" . DB_HOST .
               ";dbname=" . DB_NAME .
               ";charset=utf8mb4";

        $pdo = new PDO(
            $dsn,
            DB_USER,
            DB_PASSWORD
        );

        // Enable PDO exceptions
        $pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        // Return database results as associative arrays
        $pdo->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );

        // Use native MySQL prepared statements
        $pdo->setAttribute(
            PDO::ATTR_EMULATE_PREPARES,
            false
        );

        return $pdo;

    } catch (PDOException $e) {

        return null;
    }
}

