<?php
$dbPath = __DIR__ . '/store_database.db';
$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("
    CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL UNIQUE,
        price REAL NOT NULL
    )
");

$pdo->exec("DELETE FROM products ");

$pdo->exec("DELETE FROM sqlite_sequence WHERE name='products'");

$pdo->exec("
    INSERT INTO products (name, price) VALUES
    ('Яблука червоні', 17.50),
    ('Картопля молода', 11.20),
    ('Морква свіжа', 8.30),
    ('Огірки короткоплідні', 23.00),
    ('Помідори рожеві', 27.40),
    ('Яйця курячі, 10 шт.', 32.00),
    ('Олія соняшникова', 49.90)
");

echo "База даних та таблиці були успішно створені!";
