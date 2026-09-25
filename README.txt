════════════════════════════════════════
  ধার দে 🙏 — Setup Instructions
════════════════════════════════════════

STEP 1 — Install XAMPP
  Download: https://www.apachefriends.org
  Install and open XAMPP Control Panel

STEP 2 — Start Services
  Click START on both: Apache and MySQL

STEP 3 — Copy Project
  Put this entire "dhaar-de" folder inside:
  C:/xampp/htdocs/dhaar-de/

STEP 4 — Create Database
  Open browser → http://localhost/phpmyadmin
  Click "New" → Database name: dhaar_de → Create
  Click on "dhaar_de" → SQL tab
  Copy-paste the entire content of database.sql
  Click "Go"

STEP 5 — Run the App
  Open: http://localhost/dhaar-de/

════════════════════════════════════════
  PROJECT STRUCTURE
════════════════════════════════════════

dhaar-de/
│
├── index.php             ← Landing page (PHP logic)
├── login.php             ← Login (PHP logic)
├── register.php          ← Register (PHP logic)
├── dashboard.php         ← Dashboard (PHP logic)
├── debts.php             ← All debts (PHP logic)
├── debt-detail.php       ← Debt detail + actions (PHP logic)
├── add-debt.php          ← Add new debt (PHP logic)
├── friends.php           ← Friends (PHP logic)
├── shame-board.php       ← Shame board (PHP logic)
├── analytics.php         ← Charts & stats (PHP logic)
├── settings.php          ← Account settings (PHP logic)
├── settle.php            ← Share link page (PHP logic)
├── logout.php            ← Logout
├── database.sql          ← Database setup
│
├── views/                ← HTML templates (one per page)
│   ├── index.html.php
│   ├── login.html.php
│   ├── register.html.php
│   ├── dashboard.html.php
│   ├── debts.html.php
│   ├── debt-detail.html.php
│   ├── add-debt.html.php
│   ├── friends.html.php
│   ├── shame-board.html.php
│   ├── analytics.html.php
│   ├── settings.html.php
│   └── settle.html.php
│
├── css/                  ← Stylesheets
│   ├── style.css         ← Global styles
│   ├── auth.css          ← Login/Register styles
│   └── dashboard.css     ← Dashboard styles
│
├── js/
│   └── main.js           ← JavaScript (toast, search, tabs, etc.)
│
├── includes/             ← Shared PHP helpers
│   ├── db.php            ← Database connection
│   ├── auth.php          ← Session/login helpers
│   ├── functions.php     ← Helper functions
│   └── navbar.php        ← Shared navigation HTML
│
└── api/
    └── mark-read.php     ← Notifications API

════════════════════════════════════════
  HOW IT WORKS
════════════════════════════════════════

Each page is split into two files:

  dashboard.php        — runs DB queries, handles POST
  views/dashboard.html.php  — displays the HTML using $variables

This keeps PHP logic and HTML templates separate.
CSS goes in css/, JavaScript goes in js/.

════════════════════════════════════════
  TEST ACCOUNTS
════════════════════════════════════════
  Email: rakib@test.com   Password: password
  Email: sadia@test.com   Password: password
  Email: nayeem@test.com  Password: password

════════════════════════════════════════
  ALL PAGES
════════════════════════════════════════
  http://localhost/dhaar-de/
  http://localhost/dhaar-de/register.php
  http://localhost/dhaar-de/login.php
  http://localhost/dhaar-de/dashboard.php
  http://localhost/dhaar-de/debts.php
  http://localhost/dhaar-de/add-debt.php
  http://localhost/dhaar-de/friends.php
  http://localhost/dhaar-de/shame-board.php
  http://localhost/dhaar-de/analytics.php
  http://localhost/dhaar-de/settings.php
