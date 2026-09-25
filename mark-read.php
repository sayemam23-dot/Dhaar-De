<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit;
}

$pdo->prepare('UPDATE notifications SET is_read=1 WHERE user_id=?')
    ->execute([$_SESSION['user_id']]);

echo json_encode(['ok' => true]);
