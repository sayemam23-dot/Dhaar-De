<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সব ধার — ধার দে 🙏</title>
    <link rel="stylesheet" href="/dhaar-de/css/style.css">
    <link rel="stylesheet" href="/dhaar-de/css/dashboard.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="page-wrap">
    <div class="page-header flex-between" style="flex-wrap:wrap;gap:12px">
        <div>
            <h1>💸 সব ধার</h1>
            <p>মোট <?= count($debts) ?>টি ধার</p>
        </div>
        <a href="/dhaar-de/add-debt.php" class="btn btn-primary">➕ নতুন ধার</a>
    </div>

    <div class="card" style="padding:0;overflow:hidden">

        <div class="tab-bar">
            <a href="?tab=all"  class="tab-btn <?= $tab === 'all'  ? 'active' : '' ?>">সব</a>
            <a href="?tab=owe"  class="tab-btn <?= $tab === 'owe'  ? 'active' : '' ?>">আমি নিয়েছি 😅</a>
            <a href="?tab=lent" class="tab-btn <?= $tab === 'lent' ? 'active' : '' ?>">আমি দিয়েছি 🤝</a>
            <a href="?tab=done" class="tab-btn <?= $tab === 'done' ? 'active' : '' ?>">শেষ হয়েছে ✅</a>
        </div>

        <div class="search-bar">
            <input
                type="text"
                id="searchInput"
                placeholder="নাম বা কারণ দিয়ে খুঁজুন..."
                oninput="filterDebts(this.value)"
            >
        </div>

        <?php if (empty($debts)): ?>
            <div class="empty-state">
                <div class="empty-icon">🎉</div>
                <h3>কোনো ধার নেই!</h3>
                <p>এই ক্যাটাগরিতে কোনো ধার পাওয়া যায়নি।</p>
            </div>
        <?php else: ?>
            <?php foreach ($debts as $d): ?>
            <?php
                $isLender  = $d['lender_id'] == $uid;
                $other     = $isLender ? $d['borrower_name'] : $d['lender_name'];
                $remaining = $d['amount'] - $d['paid_amount'];
                $st        = overdueStatus($d['due_date']);
                $pct       = $d['amount'] > 0 ? round($d['paid_amount'] / $d['amount'] * 100) : 0;
            ?>
            <div class="debt-row" data-search="<?= htmlspecialchars(strtolower($other . ' ' . $d['reason'])) ?>">
                <div class="avatar" style="background:<?= avatarColor($other) ?>">
                    <?= mb_strtoupper(mb_substr($other, 0, 2)) ?>
                </div>
                <div class="debt-info">
                    <div class="debt-name"><?= htmlspecialchars($other) ?></div>
                    <div class="debt-reason"><?= htmlspecialchars($d['reason'] ?: '—') ?></div>
                    <?php if ($d['paid_amount'] > 0): ?>
                    <div class="progress-bar" style="margin-top:6px;width:160px">
                        <div class="progress-fill" style="width:<?= $pct ?>%"></div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="debt-right">
                    <div class="debt-amount <?= $isLender ? 'green' : 'red' ?>">
                        <?= ($isLender ? '+' : '-') . taka($remaining) ?>
                    </div>
                    <div class="debt-date">
                        <?= $d['due_date'] ? date('d M Y', strtotime($d['due_date'])) : 'তারিখ নেই' ?>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:6px;align-items:flex-end">
                    <span class="pill pill-<?= $d['status'] === 'active' || $d['status'] === 'partial' ? $st : $d['status'] ?>">
                        <?= match($d['status']) {
                            'pending'   => '⏳ অপেক্ষায়',
                            'active'    => overdueLabel($st),
                            'partial'   => "📊 {$pct}% দেওয়া",
                            'settled'   => '✅ শেষ',
                            'forgiven'  => '💚 মাফ',
                            'contested' => '⚠️ বিতর্কিত',
                            default     => $d['status']
                        } ?>
                    </span>
                    <a href="/dhaar-de/debt-detail.php?id=<?= $d['id'] ?>" class="btn btn-outline btn-sm">বিস্তারিত</a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script src="/dhaar-de/js/main.js"></script>
</body>
</html>
