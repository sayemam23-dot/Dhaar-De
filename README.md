# ধার দে 🙏 (Dhar De)

A Bengali debt-tracking web app for friends, family and classmates in Bangladesh. Track who owes whom, confirm debts from both sides, and settle up without the awkward conversation.

**🔗 Live demo:** `https://sayemam23-dot.github.io/Dhaar-De/#/`

> Built as a team project at Daffodil International University.

## Features

- **Dual confirmation:** a debt only becomes active once both lender and borrower confirm it
- **SmartSettle™:** counter-debts between two people are netted into a single payment
- **Shame Board:** overdue borrowers (30+ and 60+ days) show up publicly, with opt-out in settings
- **Per-debt chat** and **partial payments** with history
- **Debt Score** and **achievement badges**
- Analytics, friends, share-link confirmation (PHP version)

## Two versions in this repo

| | Where | Stack | Data |
|---|---|---|---|
| **Live demo** | repo root: a single self-contained `index.html` | HTML, CSS, vanilla JS | Browser `localStorage`, seeded with sample users |
| **Full app** | [`php-version/`](php-version) | PHP, MySQL (PDO), HTML/CSS/JS | Real database, login, sessions |

GitHub Pages only serves static files, so it can't run PHP or MySQL. The demo re-implements the core flows (dashboard, add debt, dual confirm, payments, forgive/settle, SmartSettle, chat, Shame Board) in the browser. The original PHP source is included untouched.

## Try the demo

Use the 👤 dropdown in the navbar to switch between Rakib, Sadia and Nayeem:

1. As **Rakib**, open the pending debt from Nayeem and confirm it.
2. Open Rakib's dashboard: Sadia owes and is owed, so **SmartSettle** offers to net it.
3. Check the **Shame Board** for overdue borrowers.

## Run the full PHP version

1. Install [XAMPP](https://www.apachefriends.org) and start Apache + MySQL
2. Copy `php-version/` to `C:/xampp/htdocs/dhaar-de/`
3. In phpMyAdmin, create database `dhaar_de` and import `php-version/database.sql`
4. Open `http://localhost/dhaar-de/`

Test login: `rakib@test.com` / `password`

## Deploy the demo on GitHub Pages

1. Push this folder's contents to a new GitHub repo, so `index.html` sits at the **top level** of the repo (not inside a subfolder)
2. **Settings → Pages → Build and deployment**: Source `Deploy from a branch`, Branch `main`, folder `/ (root)`
3. Wait a minute, then open the URL GitHub shows

## Screenshots

<img width="1600" height="751" alt="1777050997423" src="https://github.com/user-attachments/assets/9059c53a-b3bb-44b2-a28c-36737dc923e9" />

