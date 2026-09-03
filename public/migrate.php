<?php
// Temporary migration script - DELETE after use!

$host    = getenv('DB_HOST') ?: 'localhost';
$port    = getenv('DB_PORT') ?: '3306';
$dbname  = getenv('DB_NAME') ?: 'mydb';
$user    = getenv('DB_USER') ?: 'root';
$pass    = getenv('DB_PASSWORD') ?: '';
$charset = getenv('DB_CHARSET') ?: 'utf8mb4';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Create table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            username VARCHAR(100) NOT NULL UNIQUE
        )
    ");

    // Insert sample data (only if table is empty)
    $count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("
            INSERT INTO users (first_name, last_name, email, username) VALUES
            ('Juan', 'Dela Cruz', 'juan@example.com', 'juandelacruz'),
            ('Maria', 'Santos', 'maria@example.com', 'mariasantos'),
            ('Pedro', 'Garcia', 'pedro@example.com', 'pedrogarcia'),
            ('Ana', 'Reyes', 'ana@example.com', 'anareyes'),
            ('Jose', 'Mendoza', 'jose@example.com', 'josemendoza')
        ");
        echo "✅ Table created and sample data inserted successfully!";
    } else {
        echo "✅ Table already exists with $count row(s). No new data inserted.";
    }
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
