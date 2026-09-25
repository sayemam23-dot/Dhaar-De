<?php
session_start();
require 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: /dhaar-de/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user']    = $user;
        header('Location: /dhaar-de/dashboard.php');
        exit;
    } else {
        $error = 'ইমেইল বা পাসওয়ার্ড ভুল হয়েছে।';
    }
}

require 'views/login.html.php';
