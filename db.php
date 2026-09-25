<?php
$host   = 'localhost';
$dbname = 'dhaar_de';
$user   = 'root';
$pass   = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die('<div style="font-family:sans-serif;padding:30px;color:#c0392b">
        <h2>Database connection failed</h2>
        <p>' . $e->getMessage() . '</p>
        <p>Make sure XAMPP MySQL is running and the <strong>dhaar_de</strong> database exists.</p>
    </div>');
}
