<?php

header("Content-Type: application/json");

$result = [
    "php_version" => PHP_VERSION,
    "pdo_mysql_driver" => in_array("mysql", PDO::getAvailableDrivers()),
    "mysql_connection" => false,
    "error" => null
];

try {

    $host = getenv("MYSQLHOST") ?: "";
    $port = getenv("MYSQLPORT") ?: "3306";
    $database = getenv("MYSQLDATABASE") ?: "";
    $username = getenv("MYSQLUSER") ?: "";
    $password = getenv("MYSQLPASSWORD") ?: "";

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

    $result["mysql_connection"] = true;

} catch (Throwable $e) {

    $result["error"] = $e->getMessage();
}

echo json_encode(
    $result,
    JSON_PRETTY_PRINT
);