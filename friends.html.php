<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>বন্ধু — ধার দে 🙏</title>
    <link rel="stylesheet" href="/dhaar-de/css/style.css">
    <link rel="stylesheet" href="/dhaar-de/css/dashboard.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="page-wrap">
    <div class="page-header"><h1>👥 বন্ধু</h1></div>

    <?php if ($error):   ?><div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success">✅ <?= htmlspecialchars($success) ?></div><?php endif; ?>

    <div class="grid-2" style="gap:20px;align-items:start">

        <div>
            <div class="card" style="margin-bottom:20px">
                <div class="card-header"><h3>নতুন বন্ধু যোগ করুন</h3></div>
                <form method="POST">
                    <input type="hidden" name="action" value="add_friend">
                    <div class="form-group">
                        <label class="form-label">বন্ধুর ইমেইল</label>
                        <input class="form-input" type="email" name="email" required placeholder="friend@email.com">
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">👥 অনুরোধ পাঠান</button>
                </form>
            </div>

            <?php if (!empty($pendingList)): ?>
            <div class="card">
                <div class="card-header">
                    <h3>অপেক্ষায় থাকা অনুরোধ</h3>
                    <span class="pill pill-pending"><?= count($pendingList) ?></span>
                </div>
                <?php foreach ($pendingList as $req): ?>
                <div class="friend-row">
                    <div class="avatar" style="background:<?= avatarColor($req['name']) ?>">
                        <?= mb_strtoupper(mb_substr($req['name'], 0, 2)) ?>
                    </div>
                    <div class="friend-info">
                        <div class="friend-name"><?= htmlspecialchars($req['name']) ?></div>
                        <div class="friend-meta"><?= htmlspecialchars($req['email']) ?></div>
                    </div>
                    <div class="friend-actions">
                        <form method="POST" style="display:inline">
                            <input type="hidden" name="action" value="accept">
                            <input type="hidden" name="fid"    value="<?= $req['fid'] ?>">
                            <button class="btn btn-success btn-sm" type="submit">✓</button>
                        </form>
                        <form method="POST" style="display:inline">
                            <input type="hidden" name="action" value="reject">
                            <input type="hidden" name="fid"    value="<?= $req['fid'] ?>">
                            <button class="btn btn-outline btn-sm" type="submit">✕</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>আমার বন্ধুরা</h3>
                <span style="font-size:12px;color:var(--muted)"><?= count($friendList) ?>জন</span>
            </div>

            <?php if (empty($friendList)): ?>
            <div class="empty-state">
                <div class="empty-icon">👥</div>
                <h3>কোনো বন্ধু নেই</h3>
                <p>বাম দিক থেকে বন্ধু যোগ করুন</p>
            </div>
            <?php else: ?>
                <?php foreach ($friendList as $f): ?>
                <div class="friend-row">
                    <div class="avatar" style="background:<?= avatarColor($f['name']) ?>">
                        <?= mb_strtoupper(mb_substr($f['name'], 0, 2)) ?>
                    </div>
                    <div class="friend-info">
                        <div class="friend-name"><?= htmlspecialchars($f['name']) ?></div>
                        <div class="friend-meta">
                            Score: <?= $f['debt_score'] ?>/100
                            · <?= $f['active_debts'] ?>টি সক্রিয় ধার
                        </div>
                    </div>
                    <a href="/dhaar-de/debts.php" class="btn btn-outline btn-sm">ধার দেখুন</a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="/dhaar-de/js/main.js"></script>
</body>
</html>
