<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
require 'includes/functions.php';
requireLogin();

$uid = $_SESSION['user_id'];
$tab = $_GET['tab'] ?? 'all';

$where = match($tab) {
    'owe'   => "d.borrower_id = $uid AND d.status IN ('active','partial','pending')",
    'lent'  => "d.lender_id   = $uid AND d.status IN ('active','partial','pending')",
    'done'  => "(d.lender_id=$uid OR d.borrower_id=$uid) AND d.status IN ('settled','forgiven')",
    default => "(d.lender_id=$uid OR d.borrower_id=$uid)",
};

$stmt = $pdo->query(
    "SELECT d.*, ul.name AS lender_name, ub.name AS borrower_name
     FROM debts d
     JOIN users ul ON d.lender_id  = ul.id
     JOIN users ub ON d.borrower_id = ub.id
     WHERE $where
     ORDER BY d.created_at DESC"
);
$debts = $stmt->fetchAll();

require 'views/debts.html.php';
