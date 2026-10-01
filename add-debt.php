<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
require 'includes/functions.php';
requireLogin();

$uid   = $_SESSION['user_id'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type     = $_POST['type']     ?? 'lent';
    $email    = trim($_POST['email']   ?? '');
    $amount   = floatval($_POST['amount'] ?? 0);
    $reason   = trim($_POST['reason']  ?? '');
    $due_date = $_POST['due_date'] ?? null;

    if (!$email || $amount <= 0) {
        $error = 'ইমেইল এবং পরিমাণ দিন।';
    } else {
        $stmt = $pdo->prepare('SELECT id, name FROM users WHERE email=?');
        $stmt->execute([$email]);
        $other = $stmt->fetch();

        if (!$other) {
            $error = 'এই ইমেইলে কোনো ইউজার পাওয়া যায়নি। আগে তাকে Register করতে বলুন।';
        } elseif ($other['id'] == $uid) {
            $error = 'নিজেকে ধার দিতে পারবেন না 😄';
        } else {
            $lender_id   = $type === 'lent'     ? $uid          : $other['id'];
            $borrower_id = $type === 'borrowed' ? $uid          : $other['id'];

            $stmt = $pdo->prepare(
                'INSERT INTO debts (lender_id, borrower_id, amount, reason, due_date, status)
                 VALUES (?, ?, ?, ?, ?, "pending")'
            );
            $stmt->execute([$lender_id, $borrower_id, $amount, $reason ?: null, $due_date ?: null]);
            $debtId = $pdo->lastInsertId();

            $myName = $_SESSION['user']['name'];
            sendNotification(
                $pdo,
                $other['id'],
                "নতুন ধার অনুরোধ! {$myName} → " . taka($amount),
                "/dhaar-de/debt-detail.php?id={$debtId}"
            );

            header("Location: /dhaar-de/debt-detail.php?id={$debtId}&added=1");
            exit;
        }
    }
}

require 'views/add-debt.html.php';
