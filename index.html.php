<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ধার দে 🙏 — বন্ধুর সাথে হিসাব রাখো সহজে</title>
    <link rel="stylesheet" href="/dhaar-de/css/style.css">
    <style>
        .hero {
            padding: 90px 24px;
            text-align: center;
            max-width: 760px;
            margin: 0 auto;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--red-soft);
            color: var(--accent);
            border: 1px solid rgba(232,93,47,.3);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 24px;
        }
        .hero h1 {
            font-size: clamp(32px, 6vw, 64px);
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 18px;
        }
        .hero h1 span { color: var(--accent); }
        .hero p {
            font-size: 17px;
            color: var(--muted);
            max-width: 500px;
            margin: 0 auto 32px;
            line-height: 1.7;
        }
        .hero-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        .stats-bar {
            background: var(--text);
            color: rgba(255,255,255,.55);
            padding: 16px 32px;
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            font-size: 13px;
        }
        .stat-item { display: flex; align-items: center; gap: 8px; }
        .stat-num { color: #fff; font-weight: 700; font-size: 18px; }

        .features { padding: 70px 24px; max-width: 1100px; margin: 0 auto; }
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-top: 40px; }
        .feature-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px 20px;
            transition: transform .2s, box-shadow .2s, border-color .2s;
        }
        .feature-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); border-color: var(--accent); }
        .feature-icon { font-size: 32px; margin-bottom: 12px; }
        .feature-title { font-size: 16px; font-weight: 700; margin-bottom: 8px; }
        .feature-desc { font-size: 13px; color: var(--muted); line-height: 1.6; }

        .smartsettle-section {
            background: var(--text);
            color: #fff;
            padding: 70px 24px;
        }
        .smartsettle-inner { max-width: 800px; margin: 0 auto; text-align: center; }
        .ss-demo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            margin: 32px 0;
            flex-wrap: wrap;
        }
        .ss-box {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.15);
            border-radius: var(--radius);
            padding: 18px 22px;
            font-size: 14px;
            min-width: 150px;
        }
        .ss-box .amount { font-size: 22px; font-weight: 700; margin-top: 8px; }
        .ss-arrow { font-size: 26px; color: var(--amber); }
        .ss-result {
            background: var(--green);
            border-radius: var(--radius);
            padding: 18px 28px;
            font-size: 14px;
            font-weight: 700;
        }

        .shame-section { padding: 70px 24px; max-width: 900px; margin: 0 auto; text-align: center; }

        .personality-section { background: var(--surface); padding: 70px 24px; }
        .personality-inner { max-width: 1000px; margin: 0 auto; }
        .personality-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 36px; }
        .p-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px;
            transition: border-color .15s, transform .15s;
        }
        .p-card:hover { border-color: var(--accent); transform: translateY(-2px); }
        .p-icon { font-size: 28px; margin-bottom: 8px; }
        .p-title { font-weight: 700; font-size: 14px; margin-bottom: 4px; }
        .p-desc { font-size: 12px; color: var(--muted); }

        .cta { padding: 90px 24px; text-align: center; }
        .cta h2 { font-size: clamp(24px, 4vw, 42px); font-weight: 700; margin-bottom: 14px; }

        footer {
            background: var(--text);
            color: rgba(255,255,255,.4);
            text-align: center;
            padding: 24px;
            font-size: 13px;
        }
        footer a { color: var(--accent); text-decoration: none; }

        .section-title {
            font-size: clamp(22px, 4vw, 34px);
            font-weight: 700;
            text-align: center;
        }
        .section-sub { text-align: center; color: var(--muted); margin-top: 8px; font-size: 14px; }

        @media (max-width: 768px) {
            .features-grid, .personality-grid { grid-template-columns: 1fr; }
            .ss-demo { flex-direction: column; }
            .stats-bar { gap: 20px; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="/dhaar-de/" class="navbar-logo">ধার দে <span>🙏</span></a>
    <div class="navbar-links">
        <a href="/dhaar-de/shame-board.php" class="nav-link">😬 Shame Board</a>
        <?php if ($loggedIn): ?>
            <a href="/dhaar-de/dashboard.php" class="nav-link">📊 Dashboard</a>
            <a href="/dhaar-de/logout.php"    class="btn-nav-accent">লগআউট</a>
        <?php else: ?>
            <a href="/dhaar-de/login.php"    class="nav-link">Login</a>
            <a href="/dhaar-de/register.php" class="btn-nav-accent">শুরু করুন 🙏</a>
        <?php endif; ?>
    </div>
</nav>

<section>
    <div class="hero">
        <div class="hero-badge">🇧🇩 বাংলাদেশে তৈরি</div>
        <h1>বন্ধুর কাছে <span>টাকা চাওয়ার</span> অস্বস্তি শেষ</h1>
        <p>ধার দে দিয়ে বন্ধু, পরিবার বা সহপাঠীর সাথে টাকা লেনদেনের হিসাব রাখো — স্বচ্ছভাবে, সহজে।</p>
        <div class="hero-btns">
            <a href="/dhaar-de/register.php" class="btn btn-primary" style="font-size:16px;padding:13px 30px">
                🙏 বিনামূল্যে শুরু করুন
            </a>
            <a href="/dhaar-de/shame-board.php" class="btn btn-outline" style="font-size:16px;padding:13px 26px">
                😬 Shame Board দেখুন
            </a>
        </div>
    </div>
</section>

<div class="stats-bar">
    <div class="stat-item"><span class="stat-num">১০০%</span> বিনামূল্যে</div>
    <div class="stat-item"><span class="stat-num">Dual</span> Confirmation</div>
    <div class="stat-item"><span class="stat-num">SmartSettle™</span> অটো-নেটিং</div>
    <div class="stat-item"><span class="stat-num">Shame</span> Board 😂</div>
</div>

<section class="features">
    <h2 class="section-title">কেন ধার দে?</h2>
    <p class="section-sub">সব features একটাই অ্যাপে</p>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🤝</div>
            <div class="feature-title">Dual Confirmation</div>
            <div class="feature-desc">দুজনকেই ধার নিশ্চিত করতে হবে। কেউ মিথ্যা ধার তৈরি করতে পারবে না।</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">⚡</div>
            <div class="feature-title">SmartSettle™</div>
            <div class="feature-desc">পাল্টা ধার থাকলে অটোমেটিক হিসাব করে একটা ধারে মিলিয়ে দেয়।</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">😬</div>
            <div class="feature-title">Shame Board</div>
            <div class="feature-desc">৩০+ দিন ধার দেয়নি? সবার সামনে নাম উঠে যাবে! 😂</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">💬</div>
            <div class="feature-title">Debt Chat</div>
            <div class="feature-desc">প্রতিটি ধারের জন্য আলাদা চ্যাট — screenshot, নোট, সব।</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <div class="feature-title">Analytics</div>
            <div class="feature-desc">মাসিক চার্ট, কার সাথে বেশি ধার, গড় পরিশোধের সময় — সব দেখো।</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔗</div>
            <div class="feature-title">Share Link</div>
            <div class="feature-desc">অ্যাকাউন্ট ছাড়াও লিঙ্ক দিয়ে ধার confirm করানো যায়। ৭ দিন বৈধ।</div>
        </div>
    </div>
</section>

<section class="smartsettle-section">
    <div class="smartsettle-inner">
        <h2 class="section-title" style="color:#fff">⚡ SmartSettle™ কিভাবে কাজ করে?</h2>
        <p class="section-sub" style="color:rgba(255,255,255,.45)">দুটো ধার মিলিয়ে একটা করে দেয়</p>

        <div class="ss-demo">
            <div class="ss-box">
                <div style="color:rgba(255,255,255,.55);font-size:12px">Rakib → Sadia</div>
                <div class="amount" style="color:var(--accent)">৳৫০০</div>
            </div>
            <div class="ss-arrow">+</div>
            <div class="ss-box">
                <div style="color:rgba(255,255,255,.55);font-size:12px">Sadia → Rakib</div>
                <div class="amount" style="color:var(--green)">৳২৩০</div>
            </div>
            <div class="ss-arrow">=</div>
            <div class="ss-result">
                <div style="font-size:13px;margin-bottom:6px">শুধু এটুকু লাগবে</div>
                <div style="font-size:26px;font-weight:700">Rakib → ৳২৭০</div>
            </div>
        </div>
        <p style="color:rgba(255,255,255,.35);font-size:13px">দুটো আলাদা ধার মিলিয়ে একটা নেট পেমেন্টে সমাধান!</p>
    </div>
</section>

<section class="personality-section">
    <div class="personality-inner">
        <h2 class="section-title">🎭 তুমি কোন ধরনের?</h2>
        <p class="section-sub">ধার দে তোমার behavior দেখে Personality দেয়</p>
        <div class="personality-grid">
            <div class="p-card">
                <div class="p-icon">👻</div>
                <div class="p-title">The Phantom</div>
                <div class="p-desc">ধার নেয়, তারপর উধাও!</div>
            </div>
            <div class="p-card">
                <div class="p-icon">⚡</div>
                <div class="p-title">The Flash</div>
                <div class="p-desc">৪৮ ঘণ্টার মধ্যে পরিশোধ করে</div>
            </div>
            <div class="p-card">
                <div class="p-icon">🏆</div>
                <div class="p-title">The Saint</div>
                <div class="p-desc">ধার মাফ করে দেয় সহজেই</div>
            </div>
            <div class="p-card">
                <div class="p-icon">🎭</div>
                <div class="p-title">The Negotiator</div>
                <div class="p-desc">সবসময় কিস্তিতে দেয়</div>
            </div>
            <div class="p-card">
                <div class="p-icon">😅</div>
                <div class="p-title">The Forgetful</div>
                <div class="p-desc">৩ বার মনে করিয়ে দিলে দেয়</div>
            </div>
            <div class="p-card">
                <div class="p-icon">🤝</div>
                <div class="p-title">The Honest</div>
                <div class="p-desc">সাথে সাথেই confirm করে</div>
            </div>
        </div>
    </div>
</section>

<section class="cta">
    <h2>আজই শুরু করো 🙏</h2>
    <p style="color:var(--muted);margin-bottom:28px;font-size:16px">
        বিনামূল্যে, কোনো ক্রেডিট কার্ড লাগবে না।
    </p>
    <a href="/dhaar-de/register.php" class="btn btn-primary" style="font-size:16px;padding:13px 32px">
        🙏 ধার দে শুরু করুন — বিনামূল্যে
    </a>
</section>

<footer>
    <p>ধার দে 🙏 · বন্ধুর সাথে হিসাব রাখো সহজে · Made with ❤️ in Bangladesh</p>
    <p style="margin-top:6px">
        <a href="/dhaar-de/login.php">Login</a> ·
        <a href="/dhaar-de/register.php">Register</a> ·
        <a href="/dhaar-de/shame-board.php">Shame Board</a>
    </p>
</footer>

<div id="toast"></div>
<script src="/dhaar-de/js/main.js"></script>
</body>
</html>
