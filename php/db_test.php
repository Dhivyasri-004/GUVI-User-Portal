<?php

header("Content-Type: application/json");

$drivers = PDO::getAvailableDrivers();

$requiredVariables = [
    "MYSQLHOST",
    "MYSQLPORT",
    "MYSQLDATABASE",
    "MYSQLUSER",
    "MYSQLPASSWORD"
];

$variables = [];

foreach ($requiredVariables as $variable) {
    $value = getenv($variable);

    $variables[$variable] = [
        "available" => ($value !== false && $value !== "")
    ];
}

echo json_encode([
    "php_version" => PHP_VERSION,
    "pdo_mysql_driver" => in_array("mysql", $drivers),
    "available_pdo_drivers" => $drivers,
    "mysql_variables" => $variables
], JSON_PRETTY_PRINT);