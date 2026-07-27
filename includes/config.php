<?php
declare(strict_types=1);

const APP_NAME = 'Awesome Group Company';
const DEMO_EMAIL = 'admin@awesomegroup.test';
const DEMO_PASSWORD = 'Awesome123!';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dataDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data';
    if (!is_dir($dataDir)) {
        mkdir($dataDir, 0775, true);
    }

    $pdo = new PDO('sqlite:' . $dataDir . DIRECTORY_SEPARATOR . 'awesome.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON');
    initializeDatabase($pdo);
    return $pdo;
}

function initializeDatabase(PDO $pdo): void
{
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            full_name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS company_records (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            department TEXT NOT NULL,
            service_name TEXT NOT NULL,
            manager TEXT NOT NULL,
            email TEXT NOT NULL,
            status TEXT NOT NULL CHECK(status IN ("Active", "Pending", "Inactive")),
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
        )'
    );

    $statement = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $statement->execute([DEMO_EMAIL]);
    if (!$statement->fetch()) {
        $pdo->prepare('INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)')
            ->execute(['System Administrator', DEMO_EMAIL, password_hash(DEMO_PASSWORD, PASSWORD_DEFAULT)]);
    }

    $count = (int) $pdo->query('SELECT COUNT(*) FROM company_records')->fetchColumn();
    if ($count === 0) {
        $seed = $pdo->prepare(
            'INSERT INTO company_records (department, service_name, manager, email, status)
             VALUES (?, ?, ?, ?, ?)'
        );
        $seed->execute(['Technology', 'Cloud Solutions', 'Ama Mensah', 'technology@awesomegroup.test', 'Active']);
        $seed->execute(['Consulting', 'Business Advisory', 'Kojo Asare', 'consulting@awesomegroup.test', 'Active']);
        $seed->execute(['Operations', 'Customer Success', 'Efua Owusu', 'support@awesomegroup.test', 'Pending']);
    }
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf(): void
{
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid security token. Please return and try again.');
    }
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = compact('type', 'message');
}

function requireLogin(): void
{
    if (empty($_SESSION['user_id'])) {
        flash('error', 'Please log in to access the records dashboard.');
        header('Location: login.php');
        exit;
    }
}

