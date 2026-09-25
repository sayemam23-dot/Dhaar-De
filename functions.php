<?php
// send a notification to a user
function sendNotification($pdo, $userId, $message, $link = null) {
    $stmt = $pdo->prepare('INSERT INTO notifications (user_id, message, link) VALUES (?, ?, ?)');
    $stmt->execute([$userId, $message, $link]);
}

// create a share token for a debt (expires in 7 days)
function generateShareToken($pdo, $debtId) {
    $token   = bin2hex(random_bytes(24));
    $expires = date('Y-m-d H:i:s', strtotime('+7 days'));
    $pdo->prepare('UPDATE debts SET share_token=?, token_expires=? WHERE id=?')
        ->execute([$token, $expires, $debtId]);
    return $token;
}

// returns overdue status based on due date
function overdueStatus($dueDate) {
    if (!$dueDate) return 'ok';
    $diff = (strtotime($dueDate) - time()) / 86400;
    if ($diff < -60) return 'danger';
    if ($diff < -30) return 'warning';
    if ($diff < 0)   return 'overdue';
    if ($diff <= 5)  return 'soon';
    return 'ok';
}

function overdueLabel($status) {
    return match($status) {
        'danger'  => '🔴 ৬০+ দিন বাকি',
        'warning' => '🟡 ৩০+ দিন বাকি',
        'overdue' => '⚠️ মেয়াদোত্তীর্ণ',
        'soon'    => '🟡 শীঘ্রই শেষ',
        default   => '✅ সক্রিয়',
    };
}

// pick a color for the avatar based on name
function avatarColor($name) {
    $colors = ['#e85d2f', '#2eb87a', '#f5a623', '#6c5ce7', '#0984e3', '#e84393', '#00b894', '#d63031'];
    return $colors[ord($name[0]) % count($colors)];
}

// check if two users have debts going both ways (for SmartSettle)
function checkSmartSettle($pdo, $userA, $userB) {
    $stmt = $pdo->prepare(
        "SELECT id, lender_id, borrower_id, (amount - paid_amount) AS remaining
         FROM debts
         WHERE status IN ('active','partial')
           AND ((lender_id=? AND borrower_id=?) OR (lender_id=? AND borrower_id=?))"
    );
    $stmt->execute([$userA, $userB, $userB, $userA]);
    $debts = $stmt->fetchAll();

    if (count($debts) < 2) return null;

    $ab = array_values(array_filter($debts, fn($d) => $d['lender_id'] == $userA));
    $ba = array_values(array_filter($debts, fn($d) => $d['lender_id'] == $userB));

    if (!$ab || !$ba) return null;

    $abAmt = array_sum(array_column($ab, 'remaining'));
    $baAmt = array_sum(array_column($ba, 'remaining'));

    return [
        'net'       => round(abs($abAmt - $baAmt), 2),
        'direction' => $abAmt > $baAmt ? 'A_owes_B' : 'B_owes_A',
        'ab_amount' => $abAmt,
        'ba_amount' => $baAmt,
        'debts'     => $debts,
    ];
}

// give a badge to a user (skips if already earned)
function awardBadge($pdo, $userId, $badgeType) {
    $check = $pdo->prepare('SELECT id FROM badges WHERE user_id=? AND badge_type=?');
    $check->execute([$userId, $badgeType]);
    if (!$check->fetch()) {
        $pdo->prepare('INSERT INTO badges (user_id, badge_type) VALUES (?, ?)')
            ->execute([$userId, $badgeType]);
        sendNotification($pdo, $userId, '🏅 নতুন Badge অর্জিত: ' . $badgeType);
    }
}

// adjust a user's debt score (capped between 0 and 100)
function updateDebtScore($pdo, $userId, $delta) {
    $stmt = $pdo->prepare('UPDATE users SET debt_score = GREATEST(0, LEAST(100, debt_score + ?)) WHERE id=?');
    $stmt->execute([$delta, $userId]);
}

function taka($amount) {
    return '৳' . number_format($amount, 2);
}
