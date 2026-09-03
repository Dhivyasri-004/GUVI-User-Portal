<?php

function redisConnection()
{
    $redis = new Redis();

    $host = getenv("REDISHOST") ?: "127.0.0.1";
    $port = getenv("REDISPORT") ?: "6379";
    $password = getenv("REDISPASSWORD") ?: "";

    $redis->connect(
        $host,
        (int)$port
    );

    if ($password !== "") {
        $redis->auth($password);
    }

    return $redis;
}

function createRedisToken($email)
{
    $redis = redisConnection();

    $token = bin2hex(
        random_bytes(32)
    );

    $redis->setEx(
        "login:" . $token,
        3600,
        $email
    );

    return $token;
}

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