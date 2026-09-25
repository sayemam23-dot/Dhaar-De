<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
requireLogin();

$uid     = $_SESSION['user_id'];
$error   = $success = '';

$stmt = $pdo->prepare('SELECT * FROM users WHERE id=?');
$stmt->execute([$uid]);
$userData = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_profile') {
        $name = trim($_POST['name'] ?? '');
        if (!$name) {
            $error = 'নাম খালি রাখা যাবে না।';
        } else {
            $pdo->prepare('UPDATE users SET name=? WHERE id=?')->execute([$name, $uid]);
            $_SESSION['user']['name'] = $name;
            $userData['name'] = $name;
            $success = 'প্রোফাইল আপডেট হয়েছে।';
        }

    } elseif ($action === 'change_password') {
        $old  = $_POST['old_password']  ?? '';
        $new  = $_POST['new_password']  ?? '';
        $new2 = $_POST['new_password2'] ?? '';

        if (!password_verify($old, $userData['password'])) {
            $error = 'পুরনো পাসওয়ার্ড ভুল।';
        } elseif (strlen($new) < 6) {
            $error = 'নতুন পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।';
        } elseif ($new !== $new2) {
            $error = 'নতুন পাসওয়ার্ড দুটো মিলছে না।';
        } else {
            $hash = password_hash($new, PASSWORD_BCRYPT);
            $pdo->prepare('UPDATE users SET password=? WHERE id=?')->execute([$hash, $uid]);
            $success = 'পাসওয়ার্ড পরিবর্তন হয়েছে।';
        }

    } elseif ($action === 'shame_toggle') {
        $val = isset($_POST['shame_opt']) ? 1 : 0;
        $pdo->prepare('UPDATE users SET shame_opt=? WHERE id=?')->execute([$val, $uid]);
        $userData['shame_opt'] = $val;
        $success = 'Shame Board সেটিং আপডেট হয়েছে।';
    }
}

require 'views/settings.html.php';
