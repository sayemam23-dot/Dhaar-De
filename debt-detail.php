<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
require 'includes/functions.php';
requireLogin();

$uid    = $_SESSION['user_id'];
$debtId = intval($_GET['id'] ?? 0);

$stmt = $pdo->prepare(
    "SELECT d.*, ul.name AS lender_name, ul.email AS lender_email,
                  ub.name AS borrower_name, ub.email AS borrower_email
     FROM debts d
     JOIN users ul ON d.lender_id   = ul.id
     JOIN users ub ON d.borrower_id = ub.id
     WHERE d.id = ? AND (d.lender_id = ? OR d.borrower_id = ?)"
);
$stmt->execute([$debtId, $uid, $uid]);
$debt = $stmt->fetch();

if (!$debt) {
    header('Location: /dhaar-de/debts.php');
    exit;
}

$msgStmt = $pdo->prepare(
    "SELECT m.*, u.name AS sender_name
     FROM messages m
     JOIN users u ON m.sender_id = u.id
     WHERE m.debt_id = ?
     ORDER BY m.created_at ASC"
);
$msgStmt->execute([$debtId]);
$messages = $msgStmt->fetchAll();

$payStmt = $pdo->prepare(
    "SELECT p.*, u.name AS payer_name
     FROM payments p
     JOIN users u ON p.paid_by = u.id
     WHERE p.debt_id = ?
     ORDER BY p.created_at DESC"
);
$payStmt->execute([$debtId]);
$payments = $payStmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'confirm') {
        $col = $uid == $debt['lender_id'] ? 'lender_confirmed' : 'borrower_confirmed';
        $pdo->prepare("UPDATE debts SET $col = 1 WHERE id = ?")->execute([$debtId]);

        $c = $pdo->prepare('SELECT lender_confirmed, borrower_confirmed FROM debts WHERE id=?');
        $c->execute([$debtId]);
        $row = $c->fetch();
        if ($row['lender_confirmed'] && $row['borrower_confirmed']) {
            $pdo->prepare("UPDATE debts SET status='active' WHERE id=?")->execute([$debtId]);
            $otherId = $uid == $debt['lender_id'] ? $debt['borrower_id'] : $debt['lender_id'];
            sendNotification($pdo, $otherId, 'ধার নিশ্চিত হয়েছে ✓ ' . taka($debt['amount']), "/dhaar-de/debt-detail.php?id={$debtId}");
        }
        header("Location: /dhaar-de/debt-detail.php?id={$debtId}");
        exit;

    } elseif ($action === 'forgive' && $uid == $debt['lender_id']) {
        $pdo->prepare("UPDATE debts SET status='forgiven' WHERE id=?")->execute([$debtId]);
        sendNotification($pdo, $debt['borrower_id'],
            'তোমার ' . taka($debt['amount']) . ' ধার মাফ করা হয়েছে 💚',
            "/dhaar-de/debt-detail.php?id={$debtId}"
        );
        awardBadge($pdo, $uid, 'forgiver');
        header("Location: /dhaar-de/debt-detail.php?id={$debtId}&forgiven=1");
        exit;

    } elseif ($action === 'settle') {
        $pdo->prepare("UPDATE debts SET status='settled', paid_amount=amount WHERE id=?")->execute([$debtId]);
        awardBadge($pdo, $uid, 'first_settle');
        updateDebtScore($pdo, $debt['borrower_id'], +10);
        $otherId = $uid == $debt['lender_id'] ? $debt['borrower_id'] : $debt['lender_id'];
        sendNotification($pdo, $otherId, 'ধার সম্পূর্ণ পরিশোধ হয়েছে 🎉', "/dhaar-de/debt-detail.php?id={$debtId}");
        header("Location: /dhaar-de/debt-detail.php?id={$debtId}&settled=1");
        exit;

    } elseif ($action === 'contest') {
        $pdo->prepare("UPDATE debts SET status='contested' WHERE id=?")->execute([$debtId]);
        $otherId = $uid == $debt['lender_id'] ? $debt['borrower_id'] : $debt['lender_id'];
        sendNotification($pdo, $otherId, '⚠️ ধার নিয়ে আপত্তি জানানো হয়েছে।', "/dhaar-de/debt-detail.php?id={$debtId}");
        header("Location: /dhaar-de/debt-detail.php?id={$debtId}");
        exit;

    } elseif ($action === 'pay') {
        $payAmt = floatval($_POST['pay_amount'] ?? 0);
        if ($payAmt > 0) {
            $pdo->prepare('INSERT INTO payments (debt_id, paid_by, amount, note) VALUES (?,?,?,?)')
                ->execute([$debtId, $uid, $payAmt, $_POST['pay_note'] ?? null]);

            $newPaid   = $debt['paid_amount'] + $payAmt;
            $newStatus = $newPaid >= $debt['amount'] ? 'settled' : 'partial';
            $pdo->prepare('UPDATE debts SET paid_amount=?, status=? WHERE id=?')
                ->execute([$newPaid, $newStatus, $debtId]);

            $otherId = $uid == $debt['lender_id'] ? $debt['borrower_id'] : $debt['lender_id'];
            sendNotification($pdo, $otherId, taka($payAmt) . ' পেমেন্ট করা হয়েছে।', "/dhaar-de/debt-detail.php?id={$debtId}");
            updateDebtScore($pdo, $debt['borrower_id'], $newStatus === 'settled' ? +8 : +3);

            if ($newStatus === 'settled') {
                awardBadge($pdo, $uid, 'first_settle');
                header("Location: /dhaar-de/debt-detail.php?id={$debtId}&settled=1");
            } else {
                header("Location: /dhaar-de/debt-detail.php?id={$debtId}");
            }
            exit;
        }

    } elseif ($action === 'message') {
        $msg = trim($_POST['message'] ?? '');
        if ($msg) {
            $pdo->prepare('INSERT INTO messages (debt_id, sender_id, message) VALUES (?,?,?)')
                ->execute([$debtId, $uid, $msg]);
        }
        header("Location: /dhaar-de/debt-detail.php?id={$debtId}&sent=1#chat");
        exit;

    } elseif ($action === 'share_link') {
        $token    = generateShareToken($pdo, $debtId);
        $shareUrl = "http://localhost/dhaar-de/settle.php?token={$token}";
        header("Location: /dhaar-de/debt-detail.php?id={$debtId}&sharelink=" . urlencode($shareUrl));
        exit;
    }
}

$isLender       = $uid == $debt['lender_id'];
$other          = $isLender ? $debt['borrower_name'] : $debt['lender_name'];
$remaining      = $debt['amount'] - $debt['paid_amount'];
$pct            = $debt['amount'] > 0 ? round($debt['paid_amount'] / $debt['amount'] * 100) : 0;
$st             = overdueStatus($debt['due_date']);
$myConfirmed    = $uid == $debt['lender_id'] ? $debt['lender_confirmed']   : $debt['borrower_confirmed'];
$otherConfirmed = $uid == $debt['lender_id'] ? $debt['borrower_confirmed'] : $debt['lender_confirmed'];
$canAct         = in_array($debt['status'], ['pending', 'active', 'partial', 'contested']);

require 'views/debt-detail.html.php';
