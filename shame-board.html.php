<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shame Board — ধার দে 🙏</title>
    <link rel="stylesheet" href="/dhaar-de/css/style.css">
    <link rel="stylesheet" href="/dhaar-de/css/dashboard.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="page-wrap">
    <div class="page-header" style="text-align:center;margin-bottom:12px">
        <h1 style="font-size:36px">😬 Shame Board</h1>
        <p style="font-size:15px;margin-top:8px">যারা মেয়াদোত্তীর্ণ ধার পরিশোধ করেনি তাদের তালিকা।</p>
        <p style="font-size:13px;color:var(--muted);margin-top:4px">
            Settings থেকে opt-out করা যাবে — তবে সেটাও সবাই দেখতে পাবে 😂
        </p>
    </div>

    <div style="display:flex;justify-content:center;gap:20px;margin:20px 0;flex-wrap:wrap">
        <span class="pill pill-danger">🔴 ৬০+ দিন বাকি</span>
        <span class="pill pill-warning">🟡 ৩০–৬০ দিন</span>
        <span class="pill pill-overdue">🟠 ১–৩০ দিন</span>
    </div>

    <?php if (empty($shameUsers)): ?>
        <div class="empty-state">
            <div class="empty-icon">🎉</div>
            <h3>কেউ Shame Board-এ নেই!</h3>
            <p>সবাই সময়মতো পরিশোধ করছে। চমৎকার!</p>
        </div>
    <?php else: ?>
        <div class="shame-grid">
            <?php foreach ($shameUsers as $u): ?>
            <?php
                $days  = intval($u['max_days']);
                $cls   = $days > 60 ? 'danger' : ($days > 30 ? 'warning' : 'mild');
                $icon  = $days > 60 ? '🔴' : ($days > 30 ? '🟡' : '🟠');
                $color = $days > 60 ? '#e85d2f' : ($days > 30 ? '#f5a623' : '#8a7d6a');
            ?>
            <div class="shame-card shame-<?= $cls ?>">
                <div class="avatar avatar-lg" style="background:<?= $color ?>;margin:0 auto 12px">
                    <?= mb_strtoupper(mb_substr($u['name'], 0, 2)) ?>
                </div>
                <div class="shame-name"><?= htmlspecialchars($u['name']) ?></div>
                <div style="margin:10px 0">
                    <span class="pill pill-<?= $cls ?>"><?= $icon ?> <?= $days ?> দিন</span>
                </div>
                <div class="shame-days"><?= $u['overdue_count'] ?>টি মেয়াদোত্তীর্ণ ধার</div>
                <div class="shame-days" style="margin-top:4px">মোট: <?= taka($u['total_overdue']) ?></div>
                <div style="margin-top:10px">
                    <div style="font-size:10px;color:var(--muted);margin-bottom:4px">Debt Score</div>
                    <div style="font-size:20px;font-weight:700;color:<?= $u['debt_score'] < 40 ? 'var(--accent)' : 'var(--muted)' ?>">
                        <?= $u['debt_score'] ?>/100
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="/dhaar-de/js/main.js"></script>
</body>
</html>
