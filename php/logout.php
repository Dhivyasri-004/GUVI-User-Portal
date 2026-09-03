
<?php

header("Content-Type: application/json");

require_once __DIR__ . "/redis.php";

try {

    // Get login token
    $token = trim((string)($_POST["token"] ?? ""));


    // Delete login token from Redis
    if ($token !== "") {

        deleteRedisToken($token);
    }


    // Return success response
    echo json_encode([
        "success" => true,
        "message" => "Logged out successfully."
    ]);


} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Logout failed."
    ]);
}

