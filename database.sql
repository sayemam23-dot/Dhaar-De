-- ধার দে 🙏 — Database Setup
-- Run this in phpMyAdmin → SQL tab

CREATE DATABASE IF NOT EXISTS dhaar_de CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dhaar_de;

CREATE TABLE users (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(100) NOT NULL,
  email       VARCHAR(255) UNIQUE NOT NULL,
  password    VARCHAR(255) NOT NULL,
  photo       VARCHAR(500) DEFAULT NULL,
  debt_score  INT DEFAULT 50,
  shame_opt   TINYINT(1) DEFAULT 1,
  created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE debts (
  id                  INT AUTO_INCREMENT PRIMARY KEY,
  lender_id           INT NOT NULL,
  borrower_id         INT NOT NULL,
  amount              DECIMAL(12,2) NOT NULL,
  paid_amount         DECIMAL(12,2) DEFAULT 0.00,
  reason              TEXT,
  due_date            DATE,
  status              ENUM('pending','active','partial','settled','forgiven','contested') DEFAULT 'pending',
  lender_confirmed    TINYINT(1) DEFAULT 0,
  borrower_confirmed  TINYINT(1) DEFAULT 0,
  share_token         VARCHAR(100) DEFAULT NULL,
  token_expires       DATETIME DEFAULT NULL,
  created_at          DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (lender_id)   REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (borrower_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE payments (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  debt_id      INT NOT NULL,
  paid_by      INT NOT NULL,
  amount       DECIMAL(12,2) NOT NULL,
  screenshot   VARCHAR(500) DEFAULT NULL,
  confirmed    TINYINT(1) DEFAULT 0,
  note         TEXT,
  created_at   DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (debt_id) REFERENCES debts(id) ON DELETE CASCADE,
  FOREIGN KEY (paid_by) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE messages (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  debt_id    INT NOT NULL,
  sender_id  INT NOT NULL,
  message    TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (debt_id)   REFERENCES debts(id) ON DELETE CASCADE,
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE notifications (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  user_id    INT NOT NULL,
  message    TEXT NOT NULL,
  link       VARCHAR(500) DEFAULT NULL,
  is_read    TINYINT(1) DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE friendships (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  requester_id INT NOT NULL,
  addressee_id INT NOT NULL,
  status       ENUM('pending','accepted','blocked') DEFAULT 'pending',
  created_at   DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_pair (requester_id, addressee_id),
  FOREIGN KEY (requester_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (addressee_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE badges (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  user_id    INT NOT NULL,
  badge_type VARCHAR(50) NOT NULL,
  earned_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Sample data (optional)
INSERT INTO users (name, email, password, debt_score) VALUES
('Rakib Khan',   'rakib@test.com',  '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 75),
('Sadia Islam',  'sadia@test.com',  '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 60),
('Nayeem Hasan', 'nayeem@test.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 40);
-- Sample password for all: password

INSERT INTO debts (lender_id, borrower_id, amount, reason, status, lender_confirmed, borrower_confirmed) VALUES
(1, 2, 500.00, 'দুপুরের খাবার', 'active', 1, 1),
(2, 3, 1200.00, 'রিকশা ভাড়া + চা', 'active', 1, 1),
(1, 3, 300.00, 'বই কেনা', 'partial', 1, 1);

UPDATE debts SET paid_amount = 150.00 WHERE id = 3;
