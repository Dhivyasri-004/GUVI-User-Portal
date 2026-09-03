<?php

function getMySQLConnection()
{
    try {

        // Railway MySQL variables
        $host = getenv("MYSQLHOST") ?: "127.0.0.1";
        $port = getenv("MYSQLPORT") ?: "3306";
        $database = getenv("MYSQLDATABASE") ?: "guvi_portal";
        $username = getenv("MYSQLUSER") ?: "root";
        $password = getenv("MYSQLPASSWORD") ?: "root";

        $dsn = "mysql:host=" . $host .
               ";port=" . $port .
               ";dbname=" . $database .
               ";charset=utf8mb4";

        $pdo = new PDO(
            $dsn,
            $username,
            $password
        );

        $pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        $pdo->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );

        $pdo->setAttribute(
            PDO::ATTR_EMULATE_PREPARES,
            false
        );

        return $pdo;

    } catch (PDOException $e) {

        return null;
    }
}