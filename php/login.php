
<?php

header("Content-Type: application/json");

require_once __DIR__ . "/db_mysql.php";
require_once __DIR__ . "/redis.php";

try {

    // Get login data
    $email = trim((string)($_POST["email"] ?? ""));
    $password = (string)($_POST["password"] ?? "");


    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo json_encode([
            "success" => false,
            "message" => "Please enter a valid email address."
        ]);

        exit;
    }


    if ($password === "") {

        echo json_encode([
            "success" => false,
            "message" => "Please enter your password."
        ]);

        exit;
    }


    // Connect to MySQL
    $pdo = getMySQLConnection();

    if ($pdo === null) {

        echo json_encode([
            "success" => false,
            "message" => "Database connection failed."
        ]);

        exit;
    }


    // Find user using prepared statement
    $stmt = $pdo->prepare(
        "SELECT id, name, email, password_hash
         FROM users
         WHERE email = ?
         LIMIT 1"
    );

    $stmt->execute([
        $email
    ]);


    $user = $stmt->fetch();


    // Check user and password
    if (
        !$user ||
        !password_verify(
            $password,
            $user["password_hash"]
        )
    ) {

        echo json_encode([
            "success" => false,
            "message" => "Invalid email or password."
        ]);

        exit;
    }


    // Create Redis login token
    $token = createRedisToken(
        $user["email"]
    );


    // Send token to JavaScript
    echo json_encode([
        "success" => true,
        "message" => "Login successful.",
        "token" => $token
    ]);


} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Login failed."
    ]);
}

