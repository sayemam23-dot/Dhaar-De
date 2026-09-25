<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
require 'includes/functions.php';
requireLogin();

$uid  = $_SESSION['user_id'];
$user = $_SESSION['user'];

// how much the user owes others
$stmt = $pdo->prepare(
    "SELECT COALESCE(SUM(amount - paid_amount), 0)
     FROM debts WHERE borrower_id=? AND status IN ('active','partial')"
);
$stmt->execute([$uid]);
$totalOwe = $stmt->fetchColumn();

// how much others owe the user
$stmt = $pdo->prepare(
    "SELECT COALESCE(SUM(amount - paid_amount), 0)
     FROM debts WHERE lender_id=? AND status IN ('active','partial')"
);
$stmt->execute([$uid]);
$totalLent = $stmt->fetchColumn();

$net = $totalLent - $totalOwe;

// last 6 debts involving this user
$stmt = $pdo->prepare(
    "SELECT d.*, ul.name AS lender_name, ub.name AS borrower_name
     FROM debts d
     JOIN users ul ON d.lender_id  = ul.id
     JOIN users ub ON d.borrower_id = ub.id
     WHERE d.lender_id=? OR d.borrower_id=?
     ORDER BY d.created_at DESC
     LIMIT 6"
);
$stmt->execute([$uid, $uid]);
$recentDebts = $stmt->fetchAll();

// badges
$badgeStmt = $pdo->prepare('SELECT badge_type FROM badges WHERE user_id=?');
$badgeStmt->execute([$uid]);
$earnedBadges = array_column($badgeStmt->fetchAll(), 'badge_type');

$allBadges = [
    ['type' => 'first_settle', 'icon' => '🥇', 'label' => 'First Settle'],
    ['type' => 'flash',        'icon' => '⚡', 'label' => 'The Flash'],
    ['type' => 'on_fire',      'icon' => '🔥', 'label' => 'On Fire'],
    ['type' => 'clean_slate',  'icon' => '💚', 'label' => 'Clean Slate'],
    ['type' => 'forgiver',     'icon' => '🕊️', 'label' => 'Forgiver'],
    ['type' => 'early_bird',   'icon' => '⏰', 'label' => 'Early Bird'],
    ['type' => 'trusted',      'icon' => '👑', 'label' => 'Trusted'],
    ['type' => 'honest',       'icon' => '🤝', 'label' => 'Honest'],
];

// debt score
$stmt = $pdo->prepare('SELECT debt_score FROM users WHERE id=?');
$stmt->execute([$uid]);
$debtScore = $stmt->fetchColumn();

require 'views/dashboard.html.php';
