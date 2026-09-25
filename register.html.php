<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — ধার দে 🙏</title>
    <link rel="stylesheet" href="/dhaar-de/css/style.css">
    <link rel="stylesheet" href="/dhaar-de/css/auth.css">
</head>
<body class="auth-page">

<div class="auth-card">
    <div class="auth-logo">ধার দে 🙏</div>
    <div class="auth-subtitle">বন্ধুর সাথে হিসাব রাখো সহজে</div>
    <h2 class="auth-title">নতুন অ্যাকাউন্ট তৈরি করুন</h2>

    <?php if ($error): ?>
        <div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label class="form-label">আপনার নাম</label>
            <input class="form-input" type="text" name="name" required
                placeholder="Rakib Khan"
                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label class="form-label">ইমেইল</label>
            <input class="form-input" type="email" name="email" required
                placeholder="rakib@email.com"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label class="form-label">পাসওয়ার্ড</label>
            <input class="form-input" type="password" name="password" required placeholder="কমপক্ষে ৬ অক্ষর">
        </div>
        <div class="form-group">
            <label class="form-label">পাসওয়ার্ড আবার দিন</label>
            <input class="form-input" type="password" name="password2" required placeholder="একই পাসওয়ার্ড আবার দিন">
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:4px">
            🙏 Register করুন
        </button>
    </form>

    <p class="auth-switch">আগেই অ্যাকাউন্ট আছে? <a href="/dhaar-de/login.php">Login করুন</a></p>
</div>

<div id="toast"></div>
<script src="/dhaar-de/js/main.js"></script>
</body>
</html>
