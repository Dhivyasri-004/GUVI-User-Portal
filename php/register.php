<?php

header("Content-Type: application/json");

require_once __DIR__ . "/db_mysql.php";

try {

    $name = trim((string)($_POST["name"] ?? ""));
    $email = trim((string)($_POST["email"] ?? ""));
    $password = (string)($_POST["password"] ?? "");

    if ($name === "") {
        echo json_encode([
            "success" => false,
            "message" => "Please enter your name."
        ]);
        exit;
    }

    if (strlen($name) > 100) {
        echo json_encode([
            "success" => false,
            "message" => "Name must not exceed 100 characters."
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "success" => false,
            "message" => "Please enter a valid email address."
        ]);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode([
            "success" => false,
            "message" => "Password must contain at least 6 characters."
        ]);
        exit;
    }

    $pdo = getMySQLConnection();

    if ($pdo === null) {
        echo json_encode([
            "success" => false,
            "message" => "Database connection failed."
        ]);
        exit;
    }

    $check = $pdo->prepare(
        "SELECT id
         FROM users
         WHERE email = ?
         LIMIT 1"
    );

    $check->execute([
        $email
    ]);

    if ($check->fetch()) {
        echo json_encode([
            "success" => false,
            "message" => "Email is already registered."
        ]);
        exit;
    }

    $passwordHash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    if ($passwordHash === false) {
        echo json_encode([
            "success" => false,
            "message" => "Unable to secure the password."
        ]);
        exit;
    }

    $insert = $pdo->prepare(
        "INSERT INTO users
        (name, email, password_hash)
        VALUES (?, ?, ?)"
    );

    $insert->execute([
        $name,
        $email,
        $passwordHash
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Registration successful."
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "REGISTER ERROR",
        "error" => $e->getMessage()
    ]);
}