<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/db.php';

$uid        = $_SESSION['user_id'] ?? null;
$notifCount = 0;
$notifs     = [];

if ($uid) {
    $s = $pdo->prepare('SELECT COUNT(*) FROM notifications WHERE user_id=? AND is_read=0');
    $s->execute([$uid]);
    $notifCount = $s->fetchColumn();

    $s2 = $pdo->prepare('SELECT * FROM notifications WHERE user_id=? ORDER BY created_at DESC LIMIT 5');
    $s2->execute([$uid]);
    $notifs = $s2->fetchAll();
}

$page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar">
    <a href="/dhaar-de/index.php" class="navbar-logo">ধার দে <span>🙏</span></a>

    <div class="navbar-links">
        <?php if ($uid): ?>
            <a href="/dhaar-de/dashboard.php"   class="nav-link <?= $page === 'dashboard.php'  ? 'active' : '' ?>">📊 Dashboard</a>
            <a href="/dhaar-de/debts.php"        class="nav-link <?= $page === 'debts.php'       ? 'active' : '' ?>">💸 ধার</a>
            <a href="/dhaar-de/friends.php"      class="nav-link <?= $page === 'friends.php'     ? 'active' : '' ?>">👥 বন্ধু</a>
            <a href="/dhaar-de/shame-board.php"  class="nav-link <?= $page === 'shame-board.php' ? 'active' : '' ?>">😬 Shame</a>
            <a href="/dhaar-de/analytics.php"    class="nav-link <?= $page === 'analytics.php'   ? 'active' : '' ?>">📈 Analytics</a>

            <div class="notif-wrap" onclick="toggleNotif()">
                <span class="nav-link" style="cursor:pointer">🔔</span>
                <?php if ($notifCount > 0): ?>
                    <span class="notif-badge"><?= $notifCount ?></span>
                <?php endif; ?>
                <div class="notif-dropdown" id="notifDropdown">
                    <div class="notif-header">
                        নোটিফিকেশন
                        <a href="/dhaar-de/notifications.php" style="font-size:11px;color:var(--accent)">সব দেখুন</a>
                    </div>
                    <?php if (empty($notifs)): ?>
                        <div class="notif-empty">কোনো নোটিফিকেশন নেই</div>
                    <?php else: ?>
                        <?php foreach ($notifs as $n): ?>
                        <a href="<?= $n['link'] ?? '#' ?>" class="notif-item <?= $n['is_read'] ? '' : 'unread' ?>">
                            <?= htmlspecialchars($n['message']) ?>
                            <span class="notif-time"><?= date('d M, g:i A', strtotime($n['created_at'])) ?></span>
                        </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <a href="/dhaar-de/settings.php" class="nav-link <?= $page === 'settings.php' ? 'active' : '' ?>">⚙️</a>
            <a href="/dhaar-de/logout.php" class="btn-nav-accent">লগআউট</a>
        <?php else: ?>
            <a href="/dhaar-de/shame-board.php" class="nav-link">😬 Shame Board</a>
            <a href="/dhaar-de/login.php"        class="nav-link">Login</a>
            <a href="/dhaar-de/register.php"     class="btn-nav-accent">Register</a>
        <?php endif; ?>
    </div>
</nav>

<div id="toast"></div>

<script>
function toggleNotif() {
    var d = document.getElementById('notifDropdown');
    d.classList.toggle('open');
    fetch('/dhaar-de/api/mark-read.php', { method: 'POST' }).catch(function() {});
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.notif-wrap')) {
        var d = document.getElementById('notifDropdown');
        if (d) d.classList.remove('open');
    }
});
</script>
