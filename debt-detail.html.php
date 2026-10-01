<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($other) ?> — ধার বিবরণ</title>
    <link rel="stylesheet" href="/dhaar-de/css/style.css">
    <link rel="stylesheet" href="/dhaar-de/css/dashboard.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="page-wrap" style="max-width:720px">

    <a href="/dhaar-de/debts.php" style="font-size:13px;color:var(--muted);display:inline-flex;align-items:center;gap:6px;margin-bottom:20px">
        ← সব ধারে ফিরুন
    </a>

    <?php if (isset($_GET['sharelink'])): ?>
    <div class="alert alert-info">
        🔗 শেয়ার লিঙ্ক তৈরি হয়েছে:
        <strong><?= htmlspecialchars($_GET['sharelink']) ?></strong>
        <br><small>৭ দিন পর মেয়াদ শেষ হবে।</small>
    </div>
    <?php endif; ?>

    <div class="card" style="margin-bottom:20px">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px">
            <div style="display:flex;align-items:center;gap:14px">
                <div class="avatar avatar-lg" style="background:<?= avatarColor($other) ?>">
                    <?= mb_strtoupper(mb_substr($other, 0, 2)) ?>
                </div>
                <div>
                    <h2 style="font-size:20px;font-weight:700">
                        <?= htmlspecialchars($other) ?>
                    </h2>
                    <p style="color:var(--muted);font-size:13px"><?= htmlspecialchars($debt['reason'] ?: 'কারণ উল্লেখ নেই') ?></p>
                    <p style="color:var(--muted);font-size:12px;margin-top:3px">
                        <?= date('d M Y', strtotime($debt['created_at'])) ?>
                        <?php if ($debt['due_date']): ?>
                            · শেষ তারিখ: <?= date('d M Y', strtotime($debt['due_date'])) ?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div style="text-align:right">
                <div style="font-size:36px;font-weight:700;color:<?= $isLender ? 'var(--green)' : 'var(--accent)' ?>">
                    <?= ($isLender ? '+' : '−') . taka($remaining) ?>
                </div>
                <span class="pill pill-<?= $debt['status'] ?>">
                    <?= match($debt['status']) {
                        'pending'   => '⏳ অপেক্ষায়',
                        'active'    => '✅ সক্রিয়',
                        'partial'   => "📊 {$pct}% পরিশোধ",
                        'settled'   => '🎉 সম্পূর্ণ',
                        'forgiven'  => '💚 মাফ',
                        'contested' => '⚠️ বিতর্কিত',
                        default     => $debt['status']
                    } ?>
                </span>
            </div>
        </div>

        <div style="display:flex;gap:12px;margin-top:18px;flex-wrap:wrap">
            <div style="display:flex;align-items:center;gap:6px;font-size:13px">
                <span><?= $debt['lender_confirmed'] ? '✅' : '⏳' ?></span>
                <span style="color:var(--muted)"><?= htmlspecialchars($debt['lender_name']) ?> (Lender)</span>
            </div>
            <div style="display:flex;align-items:center;gap:6px;font-size:13px">
                <span><?= $debt['borrower_confirmed'] ? '✅' : '⏳' ?></span>
                <span style="color:var(--muted)"><?= htmlspecialchars($debt['borrower_name']) ?> (Borrower)</span>
            </div>
        </div>

        <?php if ($debt['paid_amount'] > 0): ?>
        <div class="progress-wrap">
            <div class="progress-label">
                <span>পরিশোধ: <?= taka($debt['paid_amount']) ?> / <?= taka($debt['amount']) ?></span>
                <span><?= $pct ?>%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width:<?= $pct ?>%"></div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($canAct): ?>
        <hr class="divider">
        <div style="display:flex;gap:10px;flex-wrap:wrap">

            <?php if (!$myConfirmed): ?>
            <form method="POST" style="display:inline">
                <input type="hidden" name="action" value="confirm">
                <button class="btn btn-success" type="submit">✓ নিশ্চিত করুন</button>
            </form>
            <?php endif; ?>

            <?php if ($uid == $debt['borrower_id'] && $debt['status'] !== 'pending'): ?>
            <button class="btn btn-primary" onclick="togglePayForm()">💸 পেমেন্ট করুন</button>
            <?php endif; ?>

            <?php if ($uid == $debt['lender_id'] && $debt['status'] !== 'forgiven'): ?>
            <form method="POST" style="display:inline" onsubmit="return confirm('ধার মাফ করবেন?')">
                <input type="hidden" name="action" value="forgive">
                <button class="btn btn-outline" type="submit">💚 মাফ করুন</button>
            </form>
            <?php endif; ?>

            <form method="POST" style="display:inline" onsubmit="return confirm('ধার সম্পূর্ণ পরিশোধ হয়েছে?')">
                <input type="hidden" name="action" value="settle">
                <button class="btn btn-outline" type="submit">🎉 Settle করুন</button>
            </form>

            <?php if ($debt['status'] === 'active' || $debt['status'] === 'partial'): ?>
            <form method="POST" style="display:inline" onsubmit="return confirm('সত্যিই আপত্তি করবেন?')">
                <input type="hidden" name="action" value="contest">
                <button class="btn btn-outline" type="submit">⚠️ আপত্তি</button>
            </form>
            <?php endif; ?>

            <form method="POST" style="display:inline">
                <input type="hidden" name="action" value="share_link">
                <button class="btn btn-outline" type="submit">🔗 শেয়ার লিঙ্ক</button>
            </form>
        </div>

        <div id="payForm" style="display:none;margin-top:18px;background:var(--grn-soft);border:1px solid rgba(46,184,122,.3);border-radius:var(--radius);padding:18px">
            <form method="POST">
                <input type="hidden" name="action" value="pay">
                <div class="form-group">
                    <label class="form-label">পরিমাণ (৳) — বাকি: <?= taka($remaining) ?></label>
                    <input class="form-input" type="number" name="pay_amount"
                        step="0.01" min="1" max="<?= $remaining ?>" required
                        placeholder="কত টাকা দিচ্ছেন?">
                </div>
                <div class="form-group">
                    <label class="form-label">নোট (ঐচ্ছিক)</label>
                    <input class="form-input" type="text" name="pay_note" placeholder="বিকাশ / নগদ / নগদে...">
                </div>
                <div style="display:flex;gap:10px">
                    <button type="button" class="btn btn-outline" onclick="togglePayForm()">বাতিল</button>
                    <button class="btn btn-success" type="submit">✓ পেমেন্ট রেকর্ড করুন</button>
                </div>
            </form>
        </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($payments)): ?>
    <div class="card" style="margin-bottom:20px">
        <div class="card-header"><h3>💰 পেমেন্ট ইতিহাস</h3></div>
        <?php foreach ($payments as $pay): ?>
        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--surface2)">
            <div>
                <div style="font-weight:700;font-size:14px"><?= htmlspecialchars($pay['payer_name']) ?></div>
                <div style="font-size:12px;color:var(--muted)"><?= date('d M Y, g:i A', strtotime($pay['created_at'])) ?></div>
                <?php if ($pay['note']): ?>
                    <div style="font-size:12px;color:var(--muted)"><?= htmlspecialchars($pay['note']) ?></div>
                <?php endif; ?>
            </div>
            <div style="font-size:18px;font-weight:700;color:var(--green)">
                +<?= taka($pay['amount']) ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="card" id="chat">
        <div class="card-header"><h3>💬 Debt Chat</h3></div>

        <div class="chat-box" id="chatBox">
            <?php if (empty($messages)): ?>
                <div style="text-align:center;padding:20px;color:var(--muted);font-size:13px">
                    কোনো বার্তা নেই। প্রথম বার্তা পাঠান!
                </div>
            <?php else: ?>
                <?php foreach ($messages as $msg): ?>
                <div class="chat-msg <?= $msg['sender_id'] == $uid ? 'mine' : 'theirs' ?>">
                    <div class="chat-name"><?= htmlspecialchars($msg['sender_name']) ?></div>
                    <div class="chat-bubble"><?= nl2br(htmlspecialchars($msg['message'])) ?></div>
                    <div class="chat-time"><?= date('d M, g:i A', strtotime($msg['created_at'])) ?></div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <form method="POST" class="chat-input-row">
            <input type="hidden" name="action" value="message">
            <input class="form-input" type="text" name="message" placeholder="মেসেজ লিখুন..." required>
            <button class="btn btn-primary" type="submit">পাঠান</button>
        </form>
    </div>

</div>

<script src="/dhaar-de/js/main.js"></script>
<script>
    var chatBox = document.getElementById('chatBox');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>
</body>
</html>
