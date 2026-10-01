<?php
require 'includes/db.php';
require 'includes/functions.php';

$token   = trim($_GET['token'] ?? '');
$error   = $success = '';
$debt    = null;

if ($token) {
    $stmt = $pdo->prepare(
        "SELECT d.*, ul.name AS lender_name, ub.name AS borrower_name
         FROM debts d
         JOIN users ul ON d.lender_id   = ul.id
         JOIN users ub ON d.borrower_id = ub.id
         WHERE d.share_token = ? AND d.token_expires > NOW() AND d.status NOT IN ('settled','forgiven')"
    );
    $stmt->execute([$token]);
    $debt = $stmt->fetch();

    if (!$debt) {
        $error = 'এই লিঙ্কটি আর বৈধ নেই বা মেয়াদ শেষ হয়ে গেছে।';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $debt) {
    $action     = $_POST['action'] ?? '';
    $isBorrower = ($_POST['role'] ?? '') === 'borrower';

    if ($action === 'confirm') {
        $col = $isBorrower ? 'borrower_confirmed' : 'lender_confirmed';
        $pdo->prepare("UPDATE debts SET $col=1 WHERE id=?")->execute([$debt['id']]);

        $c = $pdo->prepare('SELECT lender_confirmed, borrower_confirmed FROM debts WHERE id=?');
        $c->execute([$debt['id']]);
        $row = $c->fetch();
        if ($row['lender_confirmed'] && $row['borrower_confirmed']) {
            $pdo->prepare("UPDATE debts SET status='active' WHERE id=?")->execute([$debt['id']]);
        }

        $success = 'ধার নিশ্চিত করা হয়েছে! ধন্যবাদ 🙏';
        $debt    = null;
    }
}

require 'views/settle.html.php';
