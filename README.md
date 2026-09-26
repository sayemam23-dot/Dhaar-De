# ধার দে (Dhaar De)

**Dhaar De** is a full-stack web app for tracking debts between friends — built with a Bengali-first, socially-aware twist. Instead of just logging who owes who, it makes settling up a little more fun (and a little more accountable).

## ✨ Features

- **SmartSettle™** — Automatically nets out counter-debts. If you owe a friend ৳500 and they owe you ৳300, SmartSettle simplifies it down to a single ৳200 debt instead of tracking two separate transactions.
- **Shame Board** — A public leaderboard-style callout for people who are slow to pay back what they owe, adding light social pressure to settle debts.
- **Gamification** — Rewards and recognition mechanics to make consistent repayment feel less like a chore.
- **Per-Debt Chat** — Each individual debt has its own chat thread, so borrowers and lenders can discuss repayment, send reminders, or just negotiate terms directly.

## 🛠️ Tech Stack

- **Backend:** PHP
- **Database:** MySQL
- **Hosting:** Deployed on [InfinityFree](https://infinityfree.net/) (free PHP/MySQL hosting)

## 🎯 Motivation

Tracking informal debts among friends and family is common in everyday life but rarely has good tooling — especially with a local language and cultural context in mind. Dhaar De was built as a team project at Daffodil International University (DIU) to solve this with a lightweight, socially-engaging web app tailored for Bengali users.

## 🚀 Getting Started

### Prerequisites
- PHP 7.4+ (or your local XAMPP/WAMP/LAMP stack)
- MySQL 5.7+
- A web server (Apache/Nginx) or PHP's built-in server

### Installation

1. Clone the repository
   ```bash
   git clone https://github.com/<your-username>/dhaar-de.git
   cd dhaar-de
   ```

2. Import the database schema
   ```bash
   mysql -u <username> -p <database_name> < database/schema.sql
   ```

3. Configure your database connection in the config file (e.g. `config.php`)
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'dhaar_de');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   ```

4. Serve the app
   ```bash
   php -S localhost:8000
   ```

5. Visit `http://localhost:8000` in your browser.

## 📸 Screenshots

_Add screenshots of the dashboard, Shame Board, and per-debt chat here._

## 🤝 Contributing

This started as a DIU team project. Contributions, suggestions, and issue reports are welcome — feel free to open a pull request or issue.

## 📄 License

_Specify your license here (e.g. MIT, GPL, or "All rights reserved")._

---

Built with ❤️ to make settling debts with friends a little less awkward.
