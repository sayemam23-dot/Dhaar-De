<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';
require 'includes/functions.php';
requireLogin();

$uid   = $_SESSION['user_id'];
$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_friend') {
        $email = trim($_POST['email'] ?? '');
        $stmt  = $pdo->prepare('SELECT id, name FROM users WHERE email=? AND id != ?');
        $stmt->execute([$email, $uid]);
        $target = $stmt->fetch();

        if (!$target) {
            $error = 'এই ইমেইলে কোনো ইউজার পাওয়া যায়নি।';
        } else {
            $chk = $pdo->prepare(
                'SELECT id FROM friendships WHERE (requester_id=? AND addressee_id=?) OR (requester_id=? AND addressee_id=?)'
            );
            $chk->execute([$uid, $target['id'], $target['id'], $uid]);
            if ($chk->fetch()) {
                $error = 'ইতিমধ্যে বন্ধু অনুরোধ আছে বা বন্ধু আছে।';
            } else {
                $pdo->prepare('INSERT INTO friendships (requester_id, addressee_id) VALUES (?,?)')->execute([$uid, $target['id']]);
                sendNotification($pdo, $target['id'],
                    $_SESSION['user']['name'] . ' বন্ধু অনুরোধ পাঠিয়েছে।',
                    '/dhaar-de/friends.php'
                );
                $success = $target['name'] . '-কে বন্ধু অনুরোধ পাঠানো হয়েছে।';
            }
        }

    } elseif ($action === 'accept') {
        $fid = intval($_POST['fid'] ?? 0);
        $pdo->prepare("UPDATE friendships SET status='accepted' WHERE id=? AND addressee_id=?")->execute([$fid, $uid]);
        $success = 'বন্ধু অনুরোধ গ্রহণ করা হয়েছে।';

    } elseif ($action === 'reject') {
        $fid = intval($_POST['fid'] ?? 0);
        $pdo->prepare('DELETE FROM friendships WHERE id=? AND addressee_id=?')->execute([$fid, $uid]);
        $success = 'বন্ধু অনুরোধ বাতিল করা হয়েছে।';
    }
}

$friends = $pdo->prepare(
    "SELECT u.id, u.name, u.email, u.debt_score, f.id AS fid,
        (SELECT COUNT(*) FROM debts d
         WHERE d.status IN ('active','partial')
           AND ((d.lender_id=u.id AND d.borrower_id=?) OR (d.lender_id=? AND d.borrower_id=u.id))
        ) AS active_debts
     FROM friendships f
     JOIN users u ON (f.requester_id=u.id OR f.addressee_id=u.id) AND u.id != ?
     WHERE (f.requester_id=? OR f.addressee_id=?) AND f.status='accepted'"
);
$friends->execute([$uid, $uid, $uid, $uid, $uid]);
$friendList = $friends->fetchAll();

$pending = $pdo->prepare(
    "SELECT f.id AS fid, u.name, u.email, f.created_at
     FROM friendships f
     JOIN users u ON f.requester_id = u.id
     WHERE f.addressee_id=? AND f.status='pending'"
);
$pending->execute([$uid]);
$pendingList = $pending->fetchAll();

require 'views/friends.html.php';
