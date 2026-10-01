<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — ধার দে 🙏</title>
    <link rel="stylesheet" href="/dhaar-de/css/style.css">
    <link rel="stylesheet" href="/dhaar-de/css/dashboard.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="page-wrap">

    <div class="page-header flex-between" style="flex-wrap:wrap;gap:12px">
        <div>
            <h1>হ্যালো, <?= htmlspecialchars($user['name']) ?> 👋</h1>
            <p><?= date('l, d F Y') ?></p>
        </div>
        <a href="/dhaar-de/add-debt.php" class="btn btn-primary">➕ নতুন ধার</a>
    </div>

    <div class="bal-grid">
        <div class="bal-card bal-net">
            <div class="bal-label">Net Balance</div>
            <div class="bal-amount"><?= ($net >= 0 ? '+' : '') . taka($net) ?></div>
            <div class="bal-sub"><?= $net >= 0 ? '🎉 তুমি এগিয়ে আছ' : '😅 তোমার দেনা বেশি' ?></div>
        </div>
        <div class="bal-card bal-owe">
            <div class="bal-label">তুমি ধার নিয়েছ</div>
            <div class="bal-amount red"><?= taka($totalOwe) ?></div>
        </div>
        <div class="bal-card bal-lent">
            <div class="bal-label">তোমাকে দিতে হবে</div>
            <div class="bal-amount green"><?= taka($totalLent) ?></div>
        </div>
    </div>

    <div class="quick-actions">
        <a href="/dhaar-de/debts.php"       class="btn btn-outline">💸 সব ধার</a>
        <a href="/dhaar-de/friends.php"     class="btn btn-outline">👥 বন্ধু</a>
        <a href="/dhaar-de/shame-board.php" class="btn btn-outline">😬 Shame Board</a>
        <a href="/dhaar-de/analytics.php"   class="btn btn-outline">📈 Analytics</a>
    </div>

    <div class="grid-2" style="gap:20px">

        <div>
            <div class="card">
                <div class="card-header">
                    <h3>সাম্প্রতিক ধার</h3>
                    <a href="/dhaar-de/debts.php">সব দেখুন →</a>
                </div>

                <?php if (empty($recentDebts)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">🙏</div>
                        <h3>কোনো ধার নেই</h3>
                        <p>প্রথম ধার যোগ করুন</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($recentDebts as $d): ?>
                    <?php
                        $isLender  = $d['lender_id'] == $uid;
                        $other     = $isLender ? $d['borrower_name'] : $d['lender_name'];
                        $remaining = $d['amount'] - $d['paid_amount'];
                        $st        = overdueStatus($d['due_date']);
                    ?>
                    <div class="debt-row">
                        <div class="avatar" style="background:<?= avatarColor($other) ?>">
                            <?= mb_strtoupper(mb_substr($other, 0, 2)) ?>
                        </div>
                        <div class="debt-info">
                            <div class="debt-name"><?= htmlspecialchars($other) ?></div>
                            <div class="debt-reason"><?= htmlspecialchars($d['reason'] ?: '—') ?></div>
                        </div>
                        <div class="debt-right">
                            <div class="debt-amount <?= $isLender ? 'green' : 'red' ?>">
                                <?= ($isLender ? '+' : '-') . taka($remaining) ?>
                            </div>
                            <span class="pill pill-<?= $st ?>"><?= overdueLabel($st) ?></span>
                        </div>
                        <a href="/dhaar-de/debt-detail.php?id=<?= $d['id'] ?>" class="btn btn-outline btn-sm">
                            বিস্তারিত
                        </a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:20px">

            <div class="card">
                <div class="card-header">
                    <h3>Debt Score</h3>
                    <span class="pill <?= $debtScore >= 75 ? 'pill-ok' : ($debtScore >= 40 ? 'pill-soon' : 'pill-overdue') ?>">
                        <?= $debtScore >= 75 ? 'ভালো' : ($debtScore >= 40 ? 'ঠিক আছে' : 'খারাপ') ?>
                    </span>
                </div>
                <div style="display:flex;align-items:center;gap:20px">
                    <svg width="80" height="80" viewBox="0 0 80 80">
                        <circle cx="40" cy="40" r="34" fill="none" stroke="#ede8dd" stroke-width="8"/>
                        <circle cx="40" cy="40" r="34" fill="none"
                            stroke="<?= $debtScore >= 75 ? '#2eb87a' : ($debtScore >= 40 ? '#f5a623' : '#e85d2f') ?>"
                            stroke-width="8"
                            stroke-linecap="round"
                            stroke-dasharray="<?= round($debtScore * 2.136) ?> 213.6"
                            transform="rotate(-90 40 40)"
                        />
                        <text x="40" y="45" text-anchor="middle" font-size="18" font-weight="700" fill="#1a1510">
                            <?= $debtScore ?>
                        </text>
                    </svg>
                    <div>
                        <div style="font-size:13px;color:var(--muted)">তোমার বিশ্বাসযোগ্যতা</div>
                        <div style="font-size:24px;font-weight:700"><?= $debtScore ?>/100</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Badges</h3>
                    <span style="font-size:12px;color:var(--muted)"><?= count($earnedBadges) ?>/<?= count($allBadges) ?> অর্জিত</span>
                </div>
                <div class="badges-grid">
                    <?php foreach ($allBadges as $b): ?>
                    <div class="badge-item <?= in_array($b['type'], $earnedBadges) ? 'earned' : '' ?>">
                        <div class="badge-icon"><?= $b['icon'] ?></div>
                        <div class="badge-name"><?= $b['label'] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>

</div>

<script src="/dhaar-de/js/main.js"></script>
</body>
</html>
