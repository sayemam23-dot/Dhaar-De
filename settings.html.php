<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings — ধার দে 🙏</title>
    <link rel="stylesheet" href="/dhaar-de/css/style.css">
    <link rel="stylesheet" href="/dhaar-de/css/dashboard.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="page-wrap" style="max-width:580px">
    <div class="page-header">
        <h1>⚙️ Settings</h1>
        <p>তোমার অ্যাকাউন্ট পরিচালনা করো</p>
    </div>

    <?php if ($error):   ?><div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success">✅ <?= htmlspecialchars($success) ?></div><?php endif; ?>

    <div class="card" style="margin-bottom:20px">
        <div class="card-header"><h3>👤 প্রোফাইল আপডেট</h3></div>
        <form method="POST">
            <input type="hidden" name="action" value="update_profile">
            <div class="form-group">
                <label class="form-label">নাম</label>
                <input class="form-input" type="text" name="name"
                    value="<?= htmlspecialchars($userData['name']) ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">ইমেইল (পরিবর্তন করা যাবে না)</label>
                <input class="form-input" type="email" value="<?= htmlspecialchars($userData['email']) ?>" disabled>
            </div>
            <button class="btn btn-primary" type="submit">আপডেট করুন</button>
        </form>
    </div>

    <div class="card" style="margin-bottom:20px">
        <div class="card-header"><h3>🔑 পাসওয়ার্ড পরিবর্তন</h3></div>
        <form method="POST">
            <input type="hidden" name="action" value="change_password">
            <div class="form-group">
                <label class="form-label">পুরনো পাসওয়ার্ড</label>
                <input class="form-input" type="password" name="old_password" required>
            </div>
            <div class="form-group">
                <label class="form-label">নতুন পাসওয়ার্ড</label>
                <input class="form-input" type="password" name="new_password" required placeholder="কমপক্ষে ৬ অক্ষর">
            </div>
            <div class="form-group">
                <label class="form-label">নতুন পাসওয়ার্ড আবার</label>
                <input class="form-input" type="password" name="new_password2" required>
            </div>
            <button class="btn btn-primary" type="submit">পরিবর্তন করুন</button>
        </form>
    </div>

    <div class="card" style="margin-bottom:20px">
        <div class="card-header"><h3>😬 Shame Board সেটিং</h3></div>
        <form method="POST">
            <input type="hidden" name="action" value="shame_toggle">
            <label style="display:flex;align-items:flex-start;gap:12px;cursor:pointer">
                <input type="checkbox" name="shame_opt" style="margin-top:3px;width:16px;height:16px"
                    <?= $userData['shame_opt'] ? 'checked' : '' ?>>
                <div>
                    <div style="font-weight:700">Shame Board-এ দেখাতে রাজি</div>
                    <div style="font-size:13px;color:var(--muted);margin-top:2px">
                        বন্ধ করলে তোমার নাম Shame Board-এ দেখাবে না, তবে "অপ্ট-আউট" বলে দেখাবে 😂
                    </div>
                </div>
            </label>
            <button class="btn btn-outline" style="margin-top:16px" type="submit">সেভ করুন</button>
        </form>
    </div>

    <div class="card" style="border-color:rgba(232,93,47,.3);background:var(--red-soft)">
        <div class="card-header"><h3 style="color:var(--accent)">⚠️ Danger Zone</h3></div>
        <p style="font-size:13px;color:var(--muted);margin-bottom:16px">
            অ্যাকাউন্ট মুছলে সব ধার, বার্তা এবং ইতিহাস চিরতরে চলে যাবে।
        </p>
        <a href="/dhaar-de/logout.php" class="btn btn-outline">🚪 লগআউট</a>
    </div>
</div>

<script src="/dhaar-de/js/main.js"></script>
</body>
</html>
