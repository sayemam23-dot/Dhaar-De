<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ধার নিশ্চিত করুন — ধার দে 🙏</title>
    <link rel="stylesheet" href="/dhaar-de/css/style.css">
    <link rel="stylesheet" href="/dhaar-de/css/auth.css">
</head>
<body class="auth-page" style="align-items:flex-start;padding-top:80px">

<div class="auth-card" style="max-width:480px">
    <div class="auth-logo">ধার দে 🙏</div>

    <?php if ($error): ?>
        <div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
        <p style="text-align:center;margin-top:16px">
            <a href="/dhaar-de/" class="btn btn-outline">🏠 হোমে ফিরুন</a>
        </p>

    <?php elseif ($success): ?>
        <div class="alert alert-success" style="text-align:center;font-size:16px">🎉 <?= $success ?></div>
        <p style="text-align:center;color:var(--muted);font-size:13px;margin-top:12px">
            ধার দে-তে একাউন্ট খুলুন এবং সব ধার ট্র্যাক করুন।
        </p>
        <div style="margin-top:20px;display:flex;gap:10px;justify-content:center">
            <a href="/dhaar-de/register.php" class="btn btn-primary">Register করুন</a>
            <a href="/dhaar-de/login.php"    class="btn btn-outline">Login করুন</a>
        </div>

    <?php elseif ($debt): ?>
        <h2 class="auth-title">ধার নিশ্চিত করুন</h2>

        <div style="background:var(--bg);border:1px solid var(--border);border-radius:var(--radius);padding:18px;margin-bottom:20px">
            <div class="flex-between" style="margin-bottom:10px">
                <span style="color:var(--muted);font-size:13px">Lender (যে দিয়েছে)</span>
                <strong><?= htmlspecialchars($debt['lender_name']) ?></strong>
            </div>
            <div class="flex-between" style="margin-bottom:10px">
                <span style="color:var(--muted);font-size:13px">Borrower (যে নিয়েছে)</span>
                <strong><?= htmlspecialchars($debt['borrower_name']) ?></strong>
            </div>
            <div class="flex-between" style="margin-bottom:10px">
                <span style="color:var(--muted);font-size:13px">পরিমাণ</span>
                <strong style="font-size:20px;color:var(--accent)"><?= taka($debt['amount']) ?></strong>
            </div>
            <?php if ($debt['reason']): ?>
            <div class="flex-between">
                <span style="color:var(--muted);font-size:13px">কারণ</span>
                <span><?= htmlspecialchars($debt['reason']) ?></span>
            </div>
            <?php endif; ?>
        </div>

        <form method="POST">
            <div class="form-group">
                <label class="form-label">আপনি কে?</label>
                <select class="form-select" name="role" required>
                    <option value="borrower">আমি Borrower (ধার নিয়েছি)</option>
                    <option value="lender">আমি Lender (ধার দিয়েছি)</option>
                </select>
            </div>
            <input type="hidden" name="action" value="confirm">
            <button class="btn btn-success btn-block" type="submit">✓ ধার নিশ্চিত করুন</button>
        </form>

        <p style="text-align:center;font-size:12px;color:var(--muted);margin-top:16px">
            ধার দে-তে একাউন্ট খুলুন এবং সব ধার ট্র্যাক করুন।
            <a href="/dhaar-de/register.php" style="color:var(--accent);font-weight:700">Register করুন</a>
        </p>

    <?php else: ?>
        <div class="alert alert-error">⚠️ অবৈধ লিঙ্ক।</div>
    <?php endif; ?>
</div>

<div id="toast"></div>
<script src="/dhaar-de/js/main.js"></script>
</body>
</html>
