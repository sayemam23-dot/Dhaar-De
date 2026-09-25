<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
require 'includes/functions.php';
requireLogin();

$uid = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT COALESCE(SUM(amount),0) FROM debts WHERE lender_id=? AND status='settled'");
$stmt->execute([$uid]); $totalLentSettled = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COALESCE(SUM(amount),0) FROM debts WHERE borrower_id=? AND status='settled'");
$stmt->execute([$uid]); $totalBorrowedSettled = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM debts WHERE lender_id=? AND status='forgiven'");
$stmt->execute([$uid]); $totalForgiven = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM debts WHERE (lender_id=? OR borrower_id=?) AND status='settled'");
$stmt->execute([$uid, $uid]); $totalSettled = $stmt->fetchColumn();

// monthly data for last 6 months
$months = [];
for ($i = 5; $i >= 0; $i--) {
    $m     = date('Y-m', strtotime("-$i months"));
    $label = date('M', strtotime("-$i months"));

    $s1 = $pdo->prepare("SELECT COALESCE(SUM(amount),0) FROM debts WHERE borrower_id=? AND DATE_FORMAT(created_at,'%Y-%m')=?");
    $s1->execute([$uid, $m]); $owe = $s1->fetchColumn();

    $s2 = $pdo->prepare("SELECT COALESCE(SUM(amount),0) FROM debts WHERE lender_id=? AND DATE_FORMAT(created_at,'%Y-%m')=?");
    $s2->execute([$uid, $m]); $lent = $s2->fetchColumn();

    $months[] = ['label' => $label, 'owe' => floatval($owe), 'lent' => floatval($lent)];
}

$maxVal = max(array_merge(array_column($months, 'owe'), array_column($months, 'lent'), [1]));

$topStmt = $pdo->prepare(
    "SELECT u.name, SUM(d.amount - d.paid_amount) AS total
     FROM debts d
     JOIN users u ON (CASE WHEN d.lender_id=? THEN d.borrower_id ELSE d.lender_id END) = u.id
     WHERE (d.lender_id=? OR d.borrower_id=?) AND d.status IN ('active','partial')
     GROUP BY u.id ORDER BY total DESC LIMIT 3"
);
$topStmt->execute([$uid, $uid, $uid]);
$topPeople = $topStmt->fetchAll();

$avgStmt = $pdo->prepare(
    "SELECT AVG(DATEDIFF(MAX(p.created_at), d.created_at)) AS avg_days
     FROM debts d
     JOIN payments p ON p.debt_id = d.id
     WHERE d.borrower_id=? AND d.status='settled'"
);
$avgStmt->execute([$uid]);
$avgDays = round($avgStmt->fetchColumn() ?? 0);

require 'views/analytics.html.php';
