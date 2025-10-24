<?php
session_start();

$DB_HOST = '127.0.0.1';
$DB_NAME = 'chatdb';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error DB: " . $e->getMessage());
}

function e($s) {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}


if (!isset($_SESSION['user_id']) && !isset($_SESSION['guest_name'])) {
    $_SESSION['guest_name'] = 'Guest-' . random_int(1000, 9999);
}
?>


