<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — ধার দে 🙏</title>
    <link rel="stylesheet" href="/dhaar-de/css/style.css">
    <link rel="stylesheet" href="/dhaar-de/css/auth.css">
</head>
<body class="auth-page">

<div class="auth-card">
    <div class="auth-logo">ধার দে 🙏</div>
    <div class="auth-subtitle">বন্ধুর সাথে হিসাব রাখো সহজে</div>
    <h2 class="auth-title">লগইন করুন</h2>

    <?php if ($error): ?>
        <div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label class="form-label">ইমেইল</label>
            <input class="form-input" type="email" name="email" required
                placeholder="আপনার ইমেইল"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                autofocus>
        </div>
        <div class="form-group">
            <label class="form-label">পাসওয়ার্ড</label>
            <input class="form-input" type="password" name="password" required placeholder="আপনার পাসওয়ার্ড">
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px">
            🔑 Login করুন
        </button>
    </form>

    <p class="auth-switch">অ্যাকাউন্ট নেই? <a href="/dhaar-de/register.php">Register করুন</a></p>
</div>

<div id="toast"></div>
<script src="/dhaar-de/js/main.js"></script>
</body>
</html>
