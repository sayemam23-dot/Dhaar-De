<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নতুন ধার — ধার দে 🙏</title>
    <link rel="stylesheet" href="/dhaar-de/css/style.css">
    <link rel="stylesheet" href="/dhaar-de/css/dashboard.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="page-wrap" style="max-width:560px">
    <div class="page-header">
        <h1>নতুন ধার যোগ করুন 🙏</h1>
        <p>উভয় পক্ষকে Confirm করতে হবে।</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card">
        <form method="POST">

            <div class="form-group">
                <label class="form-label">ধারের ধরন</label>
                <div class="type-toggle">
                    <div>
                        <input class="type-option" type="radio" name="type" value="lent" id="typeLent"
                            <?= ($_POST['type'] ?? 'lent') === 'lent' ? 'checked' : '' ?>>
                        <label class="type-label" for="typeLent">🤝 আমি দিয়েছি</label>
                    </div>
                    <div>
                        <input class="type-option" type="radio" name="type" value="borrowed" id="typeBorrowed"
                            <?= ($_POST['type'] ?? '') === 'borrowed' ? 'checked' : '' ?>>
                        <label class="type-label" for="typeBorrowed">😅 আমি নিয়েছি</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">অন্য পক্ষের ইমেইল</label>
                <input
                    class="form-input"
                    type="email"
                    name="email"
                    required
                    placeholder="friend@email.com"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                >
                <div class="form-hint">তাকে অবশ্যই ধার দে-তে Register করা থাকতে হবে।</div>
            </div>

            <div class="form-group">
                <label class="form-label">পরিমাণ (টাকা)</label>
                <div style="position:relative">
                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--accent);font-weight:700;font-size:16px;pointer-events:none">৳</span>
                    <input
                        class="form-input"
                        style="padding-left:32px"
                        type="number"
                        name="amount"
                        step="0.01"
                        min="1"
                        required
                        placeholder="0.00"
                        value="<?= htmlspecialchars($_POST['amount'] ?? '') ?>"
                    >
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">কারণ</label>
                <input
                    class="form-input"
                    type="text"
                    name="reason"
                    placeholder="যেমন: দুপুরের খাবার, রিকশা ভাড়া, বই কেনা..."
                    value="<?= htmlspecialchars($_POST['reason'] ?? '') ?>"
                >
            </div>

            <div class="form-group">
                <label class="form-label">পরিশোধের শেষ তারিখ (ঐচ্ছিক)</label>
                <input
                    class="form-input"
                    type="date"
                    name="due_date"
                    min="<?= date('Y-m-d') ?>"
                    value="<?= htmlspecialchars($_POST['due_date'] ?? '') ?>"
                >
            </div>

            <div class="alert alert-info" style="margin-top:4px">
                💡 ধার যোগ করার পর উভয় পক্ষকে Confirm করতে হবে। তারপরই ধার "active" হবে।
            </div>

            <div style="display:flex;gap:10px;margin-top:20px">
                <a href="/dhaar-de/debts.php" class="btn btn-outline">বাতিল করুন</a>
                <button type="submit" class="btn btn-primary" style="flex:1">🙏 ধার যোগ করুন</button>
            </div>
        </form>
    </div>
</div>

<script src="/dhaar-de/js/main.js"></script>
</body>
</html>
