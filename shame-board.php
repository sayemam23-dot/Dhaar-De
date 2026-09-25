<?php
session_start();
require 'includes/db.php';
require 'includes/functions.php';

$stmt = $pdo->query(
    "SELECT u.id, u.name, u.debt_score,
        COUNT(d.id) AS overdue_count,
        MAX(DATEDIFF(NOW(), d.due_date)) AS max_days,
        SUM(d.amount - d.paid_amount) AS total_overdue
     FROM users u
     JOIN debts d ON d.borrower_id = u.id
     WHERE d.status IN ('active','partial')
       AND d.due_date < NOW()
       AND u.shame_opt = 1
     GROUP BY u.id
     ORDER BY max_days DESC"
);
$shameUsers = $stmt->fetchAll();

require 'views/shame-board.html.php';
