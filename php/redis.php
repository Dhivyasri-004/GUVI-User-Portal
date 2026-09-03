
<?php

require_once __DIR__ . "/config.php";


/*
 * Connect to Redis
 */
function redisConnection()
{
    $redis = new Redis();

    $redis->connect(
        REDIS_HOST,
        REDIS_PORT
    );

    return $redis;
}


/*
 * Create a login token and store it in Redis
 */
function createRedisToken($email)
{
    $redis = redisConnection();

    // Generate a secure random token
    $token = bin2hex(
        random_bytes(32)
    );

    // Store token -> email in Redis
    // Token automatically expires after the configured TTL
    $redis->setEx(
        "login:" . $token,
        REDIS_SESSION_TTL,
        $email
    );

    return $token;
}


/*
 * Get email from Redis using login token
 */
function getEmailFromToken($token)
{
    if ($token === "") {
        return null;
    }

    $redis = redisConnection();

    $email = $redis->get(
        "login:" . $token
    );

    if ($email === false) {
        return null;
    }

    return (string)$email;
}


/*
 * Delete login token from Redis
 */
function deleteRedisToken($token)
{
    if ($token === "") {
        return;
    }

    $redis = redisConnection();

    $redis->del(
        "login:" . $token
    );
}

