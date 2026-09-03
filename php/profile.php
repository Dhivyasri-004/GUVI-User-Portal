
<?php

header("Content-Type: application/json");

require_once __DIR__ . "/db_mysql.php";
require_once __DIR__ . "/redis.php";

try {

    // Get action and login token
    $action = (string)($_POST["action"] ?? "");
    $token = trim((string)($_POST["token"] ?? ""));


    // Verify login token through Redis
    $email = getEmailFromToken($token);

    if ($email === null) {

        echo json_encode([
            "success" => false,
            "message" => "Your login has expired. Please login again.",
            "logout" => true
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


    /*
     * LOAD PROFILE
     */
    if ($action === "get") {

        // Get profile using prepared statement
        $stmt = $pdo->prepare(
            "SELECT id, name, email, age, dob, contact, city, address
             FROM users
             WHERE email = ?
             LIMIT 1"
        );

        $stmt->execute([
            $email
        ]);

        $user = $stmt->fetch();


        // User not found
        if (!$user) {

            echo json_encode([
                "success" => false,
                "message" => "User account not found.",
                "logout" => true
            ]);

            exit;
        }


        // Prepare profile data
        $profileData = [
            "name" => $user["name"],
            "email" => $user["email"],
            "age" => $user["age"] ?? "",
            "dob" => $user["dob"] ?? "",
            "contact" => $user["contact"] ?? "",
            "city" => $user["city"] ?? "",
            "address" => $user["address"] ?? ""
        ];


        // Return profile data
        echo json_encode([
            "success" => true,
            "profile" => $profileData
        ]);

        exit;
    }


    /*
     * UPDATE PROFILE
     */
    if ($action === "update") {

        // Get profile details
        $age = trim((string)($_POST["age"] ?? ""));
        $dob = trim((string)($_POST["dob"] ?? ""));
        $contact = trim((string)($_POST["contact"] ?? ""));
        $city = trim((string)($_POST["city"] ?? ""));
        $address = trim((string)($_POST["address"] ?? ""));


        // Validate required fields
        if (
            $age === "" ||
            $dob === "" ||
            $contact === ""
        ) {

            echo json_encode([
                "success" => false,
                "message" => "Age, date of birth and contact are required."
            ]);

            exit;
        }


        // Update profile using prepared statement
        $stmt = $pdo->prepare(
            "UPDATE users
             SET age = ?,
                 dob = ?,
                 contact = ?,
                 city = ?,
                 address = ?
             WHERE email = ?"
        );

        $stmt->execute([
            $age,
            $dob,
            $contact,
            $city,
            $address,
            $email
        ]);


        // Return success response
        echo json_encode([
            "success" => true,
            "message" => "Profile updated successfully."
        ]);

        exit;
    }


    // Invalid action
    echo json_encode([
        "success" => false,
        "message" => "Invalid profile action."
    ]);


} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Profile operation failed."
    ]);
}

