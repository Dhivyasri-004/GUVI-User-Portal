<?php
declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/config.php";

function getMongoCollection(): MongoDB\Collection
{
    $client = new MongoDB\Client(MONGO_URI);

    return $client
        ->selectDatabase(MONGO_DATABASE)
        ->selectCollection("profiles");
}