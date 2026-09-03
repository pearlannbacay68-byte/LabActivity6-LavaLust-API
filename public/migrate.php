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

    // Drop old table if it exists (to fix column names)
    $pdo->exec("DROP TABLE IF EXISTS users");

    // Create table with correct column names
    $pdo->exec("
        CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(100) NOT NULL,
            lastname VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            username VARCHAR(100) NOT NULL UNIQUE
        )
    ");

    // Insert sample data
    $pdo->exec("
        INSERT INTO users (firstname, lastname, email, username) VALUES
        ('Juan', 'Dela Cruz', 'juan@example.com', 'juandelacruz'),
        ('Maria', 'Santos', 'maria@example.com', 'mariasantos'),
        ('Pedro', 'Garcia', 'pedro@example.com', 'pedrogarcia'),
        ('Ana', 'Reyes', 'ana@example.com', 'anareyes'),
        ('Jose', 'Mendoza', 'jose@example.com', 'josemendoza')
    ");

    echo "✅ Table recreated with correct column names and sample data inserted!";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
