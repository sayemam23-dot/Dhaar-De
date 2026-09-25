<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics — ধার দে 🙏</title>
    <link rel="stylesheet" href="/dhaar-de/css/style.css">
    <link rel="stylesheet" href="/dhaar-de/css/dashboard.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="page-wrap">
    <div class="page-header">
        <h1>📈 Analytics</h1>
        <p>তোমার ধার-দেনার পূর্ণ চিত্র</p>
    </div>

    <div class="grid-3" style="margin-bottom:24px">
        <div class="card" style="text-align:center">
            <div style="font-size:28px;margin-bottom:6px">💸</div>
            <div style="font-size:24px;font-weight:700;color:var(--green)"><?= taka($totalLentSettled) ?></div>
            <div style="font-size:12px;color:var(--muted);margin-top:4px">মোট দিয়েছ (settled)</div>
        </div>
        <div class="card" style="text-align:center">
            <div style="font-size:28px;margin-bottom:6px">😅</div>
            <div style="font-size:24px;font-weight:700;color:var(--accent)"><?= taka($totalBorrowedSettled) ?></div>
            <div style="font-size:12px;color:var(--muted);margin-top:4px">মোট নিয়েছ (settled)</div>
        </div>
        <div class="card" style="text-align:center">
            <div style="font-size:28px;margin-bottom:6px">🎉</div>
            <div style="font-size:24px;font-weight:700;color:var(--amber)"><?= $totalSettled ?>টি</div>
            <div style="font-size:12px;color:var(--muted);margin-top:4px">সম্পূর্ণ পরিশোধ</div>
        </div>
    </div>

    <div class="grid-2" style="gap:20px">

        <div class="card">
            <div class="card-header"><h3>মাসিক ধার কার্যক্রম</h3></div>
            <div class="bar-chart" style="height:200px;padding-top:0">
                <?php foreach ($months as $m): ?>
                <?php
                    $oweH  = $maxVal > 0 ? round(($m['owe']  / $maxVal) * 160) : 4;
                    $lentH = $maxVal > 0 ? round(($m['lent'] / $maxVal) * 160) : 4;
                    $oweH  = max($oweH,  4);
                    $lentH = max($lentH, 4);
                ?>
                <div class="bar-group">
                    <div class="bars">
                        <div class="bar bar-owe"
                            style="height:<?= $oweH ?>px"
                            data-h="<?= $oweH ?>"
                            data-val="<?= taka($m['owe']) ?>"
                            title="নিয়েছি: <?= taka($m['owe']) ?>">
                        </div>
                        <div class="bar bar-lent"
                            style="height:<?= $lentH ?>px"
                            data-h="<?= $lentH ?>"
                            data-val="<?= taka($m['lent']) ?>"
                            title="দিয়েছি: <?= taka($m['lent']) ?>">
                        </div>
                    </div>
                    <div class="bar-label"><?= $m['label'] ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="chart-legend">
                <span><span class="legend-dot" style="background:var(--accent)"></span>ধার নিয়েছি</span>
                <span><span class="legend-dot" style="background:var(--green)"></span>ধার দিয়েছি</span>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:20px">

            <div class="card">
                <div class="card-header"><h3>সবচেয়ে বেশি ধার যাদের সাথে</h3></div>
                <?php if (empty($topPeople)): ?>
                    <p style="color:var(--muted);font-size:13px;text-align:center;padding:16px">কোনো সক্রিয় ধার নেই।</p>
                <?php else: ?>
                    <?php foreach ($topPeople as $tp): ?>
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--surface2)">
                        <div class="avatar avatar-sm" style="background:<?= avatarColor($tp['name']) ?>">
                            <?= mb_strtoupper(mb_substr($tp['name'], 0, 2)) ?>
                        </div>
                        <div style="flex:1;font-size:13px;font-weight:700"><?= htmlspecialchars($tp['name']) ?></div>
                        <div style="font-weight:700;font-size:15px;color:var(--accent)"><?= taka($tp['total']) ?></div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="card">
                <div class="card-header"><h3>আরও তথ্য</h3></div>
                <div style="display:flex;flex-direction:column;gap:12px">
                    <div class="flex-between">
                        <span style="font-size:13px;color:var(--muted)">গড় পরিশোধের সময়</span>
                        <span style="font-weight:700"><?= $avgDays ?> দিন</span>
                    </div>
                    <div class="flex-between">
                        <span style="font-size:13px;color:var(--muted)">মোট মাফ করেছ</span>
                        <span style="font-weight:700"><?= $totalForgiven ?>টি ধার 💚</span>
                    </div>
                    <div class="flex-between">
                        <span style="font-size:13px;color:var(--muted)">সম্পূর্ণ পরিশোধ</span>
                        <span style="font-weight:700;color:var(--green)"><?= $totalSettled ?>টি ✅</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="/dhaar-de/js/main.js"></script>
</body>
</html>
