<?php
session_start();
require 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: /dhaar-de/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']  ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password']   ?? '';
    $pass2 = $_POST['password2']  ?? '';

    if (!$name || !$email || !$pass) {
        $error = 'সব তথ্য পূরণ করুন।';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'সঠিক ইমেইল দিন।';
    } elseif (strlen($pass) < 6) {
        $error = 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।';
    } elseif ($pass !== $pass2) {
        $error = 'দুটি পাসওয়ার্ড মিলছে না।';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'এই ইমেইলে আগেই অ্যাকাউন্ট আছে।';
        } else {
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $ins  = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
            $ins->execute([$name, $email, $hash]);
            $userId = $pdo->lastInsertId();

            $_SESSION['user_id'] = $userId;
            $_SESSION['user']    = ['id' => $userId, 'name' => $name, 'email' => $email];

            header('Location: /dhaar-de/dashboard.php?added=1');
            exit;
        }
    }
}

require 'views/register.html.php';
