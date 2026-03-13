<?php

// ─── Autoload core classes ────────────────────────────────────────────────────
require_once __DIR__ . '/../core/Env.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/AssetHelper.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../core/ComponentParser.php';
require_once __DIR__ . '/../core/Middleware.php';

// ─── Load environment & init helpers ─────────────────────────────────────────
$envPath = __DIR__ . '/../.env';
Env::load($envPath);
AssetHelper::init();

// ─── Start session (required for CSRF and Auth) ──────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ─── Bootstrap router ────────────────────────────────────────────────────────
$router = new Router();

// Global middlewares
$router->use(Middleware::setupGuard($envPath));
$router->use(Middleware::csrfProtection());

// ─── Setup Wizard Routes ──────────────────────────────────────────────────────

$router->get('/setup', function () {
    View::render('setup/welcome', [], 'setup');
});

$router->get('/setup/configure', function () {
    View::render('setup/configure', [], 'setup');
});

$router->post('/setup/configure', function () use ($envPath) {
    // ... validation stripped for brevity, keeping simple
    $name = trim($_POST['app_name'] ?? '');
    $url  = trim($_POST['app_url']  ?? '');

    if ($name === '' || $url === '') {
        View::render('setup/configure', ['errors' => ['All fields required'], 'old' => $_POST], 'setup');
        return;
    }

    Env::write($envPath, [
        'APP_NAME'  => $name,
        'APP_URL'   => rtrim($url, '/'),
        'APP_ENV'   => $_POST['app_env'] ?? 'local',
        'APP_DEBUG' => isset($_POST['app_debug']) ? 'true' : 'false',
        'APP_SETUP' => 'pending',
    ]);
    Env::load($envPath);
    header('Location: /setup/database');
    exit;
});

$router->get('/setup/database', function () {
    View::render('setup/database', [], 'setup');
});

$router->post('/setup/database', function () use ($envPath) {
    $host = trim($_POST['db_host']     ?? '127.0.0.1');
    $port = trim($_POST['db_port']     ?? '3306');
    $db   = trim($_POST['db_database'] ?? '');
    $user = trim($_POST['db_username'] ?? 'root');
    $pass = $_POST['db_password']      ?? '';

    if ($db !== '') {
        try {
            // Write config temporarily to test
            Env::write($envPath, [
                'DB_HOST' => $host, 'DB_PORT' => $port, 'DB_DATABASE' => $db,
                'DB_USERNAME' => $user, 'DB_PASSWORD' => $pass,
            ]);
            Env::load($envPath);
            
            Database::connection(); // Test connection
            
            // Run Migrations!
            Database::statement("
                CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
            
            Database::statement("
                CREATE TABLE IF NOT EXISTS remember_tokens (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT NOT NULL,
                    token VARCHAR(100) NOT NULL UNIQUE,
                    expires_at DATETIME NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");

            // Seed Admin User if users table is empty
            $count = Database::first("SELECT COUNT(*) as c FROM users")['c'];
            if ($count == 0) {
                $hash = password_hash('password', PASSWORD_BCRYPT);
                Database::insert("INSERT INTO users (name, email, password) VALUES (?, ?, ?)", 
                    ['Administrator', 'admin@monophp.local', $hash]);
            }

        } catch (\PDOException $e) {
            View::render('setup/database', [
                'old'             => $_POST,
                'connectionError' => 'Connection failed: ' . $e->getMessage(),
            ], 'setup');
            return;
        }
    }

    Env::write($envPath, ['APP_SETUP' => 'complete']);
    header('Location: /setup/complete');
    exit;
});

$router->get('/setup/complete', function () use ($envPath) {
    if (isset($_GET['skip_db'])) {
        Env::write($envPath, ['APP_SETUP' => 'complete']);
    }
    View::render('setup/complete', [], 'setup');
});

// ─── Application Routes ───────────────────────────────────────────────────────

$router->get('/', function () {
    View::render('index', [], 'main');
});

// Auth Routes
$router->get('/login', function () {
    Middleware::guest()('GET', '/login');
    View::render('auth/login', [], 'auth');
});

$router->post('/login', function () {
    Middleware::guest()('POST', '/login');
    
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (Auth::attempt($email, $password, $remember)) {
        header('Location: /dashboard');
        exit;
    }

    View::render('auth/login', ['error' => 'Invalid email or password.'], 'auth');
});

$router->get('/logout', function () {
    Auth::logout();
    header('Location: /');
    exit;
});

// Protected Route
$router->get('/dashboard', function () {
    Middleware::auth()('GET', '/dashboard');
    View::render('auth/dashboard', [], 'main');
});

$router->get('/docs', function () {
    View::render('docs/index', [], 'main');
});

// ─── Dispatch ─────────────────────────────────────────────────────────────────
$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);
