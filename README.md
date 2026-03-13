# MonoPHP

**MonoPHP** is a minimalist, experimental PHP framework that combines modern architecture — routing, layouts, reusable components, and a setup wizard — in a tiny, readable codebase. It integrates [Tailwind CSS](https://tailwindcss.com/) and [HTMX](https://htmx.org/) out of the box for a premium UI with zero build steps.

---

## 📋 Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
  - [Using Laragon / Apache](#using-laragon--apache)
  - [PHP Built-in Server](#php-built-in-server)
  - [First-Run Setup Wizard](#first-run-setup-wizard)
- [Environment Configuration (.env)](#environment-configuration-env)
- [How the Framework Works](#how-the-framework-works)
  - [Entry Point](#1-entry-point--publicindexphp)
  - [Env Loader](#2-env-loader--coreenvphp)
  - [Router](#3-router--corerouterphp)
  - [Middleware](#4-middleware--coremiddlewarephp)
  - [View](#5-view--coreviewphp)
  - [ComponentParser](#6-componentparser--corecomponentparserphp)
- [Request Lifecycle](#request-lifecycle)
- [Developer Guide](#developer-guide)
  - [Adding Routes](#adding-routes)
  - [Creating Pages](#creating-pages)
  - [Creating Layouts](#creating-layouts)
  - [Creating Components](#creating-components)
  - [Passing Data to Views](#passing-data-to-views)
  - [Reading Environment Values](#reading-environment-values)
- [HTMX Integration](#htmx-integration)
- [Tailwind CSS](#tailwind-css)

---

## Features

| Feature | Description |
|---|---|
| 🔀 **Dynamic Routing** | GET & POST routes with named URL parameters (`{id}`) |
| 📄 **Layout System** | Every page is wrapped in a reusable HTML shell |
| 🧩 **Component System** | Self-closing JSX-like tags for reusable UI pieces |
| ⚡ **HTMX Navigation** | SPA-like page transitions — zero JavaScript |
| 🎨 **Tailwind CSS** | Built-in via CDN Play — dark-themed premium UI |
| 🔐 **Middleware Pipeline** | Chainable middleware (setup guard, CSRF protection) |
| ⚙️ **Setup Wizard** | 4-step form wizard to configure the app on first run |
| 📁 **.env Support** | Read, write, and type-cast `.env` variables at runtime |
| 🛡️ **CSRF Protection** | Token verificationon all POST requests |

---

## Requirements

- **PHP 8.1+**
- A web server pointed at the `public/` directory (Apache, Nginx, or PHP built-in server)
- `mod_rewrite` enabled (for Apache)

---

## Project Structure

```
monophp/
├── public/
│   ├── index.php          # Entry point — all HTTP requests land here
│   └── .htaccess          # Apache URL rewriting rule
│
├── core/
│   ├── Env.php            # .env loader, getter, and writer
│   ├── Router.php         # Route registration and dispatching
│   ├── Middleware.php     # Built-in middleware (setup guard, CSRF)
│   ├── View.php           # Page renderer with HTMX partial support
│   └── ComponentParser.php# Parses and renders custom component tags
│
├── app/
│   ├── pages/
│   │   ├── index.php          # Home page  (/)
│   │   ├── errors/
│   │   │   └── 404.php        # 404 error page
│   │   ├── users/
│   │   │   ├── index.php      # User list  (/users)
│   │   │   └── show.php       # User detail (/users/{id})
│   │   └── setup/
│   │       ├── welcome.php    # Wizard step 1 — welcome & requirements
│   │       ├── configure.php  # Wizard step 2 — app name, URL, env
│   │       ├── database.php   # Wizard step 3 — DB connection
│   │       └── complete.php   # Wizard step 4 — done!
│   │
│   ├── layouts/
│   │   ├── main.php       # Main app layout (Tailwind + HTMX nav)
│   │   └── setup.php      # Setup wizard layout (step progress bar)
│   │
│   └── components/
│       └── UserCard.php   # Example reusable user card component
│
├── .env                   # Environment config (created by the wizard)
├── .env.example           # Template — copy to .env for manual setup
└── README.md
```

---

## Getting Started

### Using Laragon / Apache

Set the **document root** of your virtual host to the `public/` folder:

```
Document Root: C:/laragon/www/monophp/public
```

The included `public/.htaccess` handles URL rewriting automatically.

### PHP Built-in Server

```bash
php -S localhost:8000 -t public
```

Open [http://localhost:8000](http://localhost:8000) in your browser.

### First-Run Setup Wizard

On first access, if no `.env` file exists, the **Setup Guard middleware** automatically redirects to the setup wizard at `/setup`.

The wizard walks you through four steps:

| Step | Page | Description |
|---|---|---|
| 1 | `/setup` | Welcome screen — PHP version & write-permission checks |
| 2 | `/setup/configure` | App name, URL, environment, debug mode |
| 3 | `/setup/database` | Database host, port, name, credentials (skippable) |
| 4 | `/setup/complete` | Summary of saved configuration |

On completion, a `.env` file is written to the project root and the guard lets all future requests through.

---

## Environment Configuration (.env)

Configuration values are stored in a `.env` file in the project root:

```dotenv
# Application
APP_NAME="MonoPHP"
APP_URL=http://localhost
APP_ENV=local
APP_DEBUG=true
APP_SETUP=complete

# Database
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=MonoPHP
DB_USERNAME=root
DB_PASSWORD=
```

Copy `.env.example` to `.env` for manual configuration, or let the wizard generate it automatically.

### Type Casting

`Env::get()` automatically casts values:

| .env value | PHP type |
|---|---|
| `true` / `false` | `bool` |
| `null` | `null` |
| `42` / `3.14` | `int` / `float` |
| anything else | `string` |

---

## How the Framework Works

### 1. Entry Point — `public/index.php`

All HTTP requests are routed through this single file. It is responsible for:

1. Requiring all core classes
2. Loading the `.env` file via `Env::load()`
3. Starting the PHP session
4. Registering global middleware
5. Defining all application routes
6. Calling `$router->dispatch()` with the current method and URI

```php
$envPath = __DIR__ . '/../.env';
Env::load($envPath);

$router = new Router();
$router->use(Middleware::setupGuard($envPath));
$router->use(Middleware::csrfProtection());

$router->get('/', fn($p) => View::render('index', [], 'main'));

$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
```

---

### 2. Env Loader — `core/Env.php`

Parses `key=value` pairs from a `.env` file and populates `$_ENV`, `$_SERVER`, and `putenv()`.

```php
// Load a .env file (idempotent — safe to call multiple times)
Env::load('/path/to/.env');

// Read a value with an optional default
$name = Env::get('APP_NAME', 'My App');

// Write values back to the .env file (preserves comments)
Env::write('/path/to/.env', ['APP_SETUP' => 'complete']);
```

**Features:**
- Strips single and double quotes from values
- Casts `true`/`false`/`null`/numeric strings to native PHP types
- `write()` preserves existing lines and comments, only updating the specified keys
- Only loads once per request (idempotent)

---

### 3. Router — `core/Router.php`

Lightweight request router with GET, POST, and wildcard method support.

```php
// Register routes
$router->get('/path',        $callable);
$router->post('/path',       $callable);
$router->any('/path',        $callable); // matches all methods

// Register global middleware
$router->use($callable);

// Execute (call at end of index.php)
$router->dispatch('GET', '/users/42');
```

**Dynamic parameter conversion:**

```
Route pattern :  /users/{id}
Regex          :  #^/users/(?P<id>[^/]+)$#
Request URI    :  /users/42
$params        :  ['id' => '42']
```

---

### 4. Middleware — `core/Middleware.php`

Middleware callables receive `($method, $uri)` and return `true` (continue) or `false` (halt).

#### Built-in Middleware

**`Middleware::setupGuard($envPath)`**

Redirects unauthenticated requests to `/setup` if `APP_SETUP` is not `complete`. Once configured, redirects `/setup/*` away to prevent re-running.

**`Middleware::csrfProtection()`**

Validates the `_csrf_token` field on every `POST` request against the session. Responds with `403 Forbidden` on mismatch. Rotates the token after each request.

Usage in forms:
```html
<input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_SESSION['_csrf_token'] ?? '') ?>" />
```

#### Writing Custom Middleware

```php
$router->use(function(string $method, string $uri): bool {
    // Example: require login for all routes except /login
    if ($uri !== '/login' && !isset($_SESSION['user'])) {
        header('Location: /login');
        return false; // halt pipeline
    }
    return true; // continue
});
```

---

### 5. View — `core/View.php`

Renders a page file inside a layout, with automatic HTMX partial detection.

```php
View::render(string $page, array $data = [], string $layout = 'main'): void
```

| Parameter | Description |
|---|---|
| `$page` | Path to the page file relative to `app/pages/`, without `.php` |
| `$data` | Associative array extracted as local variables in the page |
| `$layout` | Name of the layout file in `app/layouts/`. Default: `"main"` |

**Rendering pipeline:**

```
1. extract($data)            → $data keys become local PHP variables
2. ob_start()                → begin output capture
3. require $pageFile         → execute the page file
4. $content = ob_get_clean() → capture rendered page HTML
5. ComponentParser::parse()  → resolve custom component tags
6. HX-Request header?
   ├─ YES → echo $content               (HTMX partial swap)
   └─ NO  → require $layoutFile         (full page with layout)
```

---

### 6. ComponentParser — `core/ComponentParser.php`

Scans rendered page HTML for self-closing component tags and replaces them with rendered PHP component files.

**Component tag syntax:**

```html
<!-- Uppercase first letter, self-closing, string attribute values -->
<UserCard name="Alice" id="1" />
<AlertBox type="Warning" message="Something went wrong" />
```

**How it works:**

1. Regex scans for `<[A-Z][A-Za-z0-9]+(.*)/>` patterns
2. Extracts component name → finds `app/components/{Name}.php`
3. Parses `key="value"` attributes → `extract()`s them as `$key` variables
4. Buffers `require` of the component file and substitutes the tag output

> **Note:** Only self-closing tags are supported. Attribute values must be plain strings. To pass dynamic PHP values, render them inline first: `name="<?= htmlspecialchars($user['name']) ?>"`.

---

## Request Lifecycle

```
┌─────────────────────────────────────────────────────────────┐
│                    Incoming HTTP Request                    │
└─────────────────────────────┬───────────────────────────────┘
                              │
                    public/index.php
                              │
                    Env::load(.env)
                              │
                    ┌─────────▼──────────┐
                    │  Middleware Chain   │
                    │  1. setupGuard     │
                    │  2. csrfProtection │
                    └─────────┬──────────┘
                              │
                    ┌─────────▼──────────┐
                    │   Router::dispatch │
                    │   Match URI/method │
                    └─────────┬──────────┘
                              │
                    ┌─────────▼──────────┐
                    │  Route Handler     │
                    │  (your closure)    │
                    └─────────┬──────────┘
                              │
                    ┌─────────▼──────────┐
                    │   View::render     │
                    │   extract($data)   │
                    │   render page      │
                    │   parse components │
                    └─────────┬──────────┘
                              │
               ┌──────────────┴──────────────┐
               ▼                             ▼
        HX-Request: true            Regular browser
        echo $content               require layout
        (partial swap)              (full HTML)
```

---

## Developer Guide

### Adding Routes

```php
// GET route
$router->get('/blog', function ($params) {
    View::render('blog/index', [], 'main');
});

// GET route with dynamic parameter
$router->get('/blog/{slug}', function ($params) {
    View::render('blog/post', ['slug' => $params['slug']], 'main');
});

// POST route (e.g. form submission)
$router->post('/contact', function ($params) {
    $name = htmlspecialchars($_POST['name'] ?? '');
    // process form...
    View::render('contact/thanks', ['name' => $name], 'main');
});
```

---

### Creating Pages

Create a `.php` file inside `app/pages/`. The relative path (without extension) is what you pass to `View::render()`.

**`app/pages/blog/index.php`**
```html
<h1 class="text-3xl font-bold">Blog</h1>
<p class="text-slate-400">All posts will appear here.</p>
```

Rendered with:
```php
View::render('blog/index', [], 'main');
```

---

### Creating Layouts

Create a `.php` file inside `app/layouts/`. Use `<?= $content ?>` where the page output should be injected.

**`app/layouts/minimal.php`**
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= Env::get('APP_NAME', 'App') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-white">
    <main class="container mx-auto p-8">
        <?= $content ?>
    </main>
</body>
</html>
```

Use it with:
```php
View::render('some/page', $data, 'minimal');
```

---

### Creating Components

Create a `.php` file inside `app/components/`. The filename **must start with a capital letter**.

**`app/components/AlertBox.php`**
```html
<div class="px-4 py-3 rounded-xl bg-yellow-950/60 border border-yellow-700/40 text-yellow-300 text-sm">
    <strong><?= htmlspecialchars($type) ?>:</strong>
    <?= htmlspecialchars($message) ?>
</div>
```

Use it in any page:
```html
<AlertBox type="Warning" message="This action cannot be undone." />
```

---

### Passing Data to Views

```php
$router->get('/dashboard', function ($params) {
    $data = [
        'title'    => 'Dashboard',
        'username' => 'Alice',
        'stats'    => ['orders' => 42, 'revenue' => 18500],
    ];
    View::render('dashboard', $data, 'main');
});
```

Inside `app/pages/dashboard.php`, all array keys are available as local variables:

```php
<h1><?= htmlspecialchars($title) ?></h1>
<p>Welcome, <?= htmlspecialchars($username) ?>!</p>
<p>Orders: <?= $stats['orders'] ?></p>
```

---

### Reading Environment Values

```php
// With fallback default
$name = Env::get('APP_NAME', 'MonoPHP');
$debug = Env::get('APP_DEBUG', false); // returns bool true/false
$port  = Env::get('DB_PORT', 3306);   // returns int

// In any PHP file (Env is loaded globally in index.php)
echo Env::get('APP_ENV'); // 'local', 'production', etc.
```

---

## HTMX Integration

HTMX is included in the `main` layout via CDN. Navigation links use HTMX attributes for instant page transitions without a full reload:

```html
<!-- In a layout or page -->
<a hx-get="/users" hx-target="#page" hx-push-url="true">Users</a>
```

| Attribute | Purpose |
|---|---|
| `hx-get="/path"` | Sends a GET request to `/path` on click |
| `hx-target="#page"` | Injects the response into `#page` |
| `hx-push-url="true"` | Updates the browser URL bar |

When HTMX fires a request, it includes the `HX-Request: true` header. `View::render()` detects this and returns **only** the page content — no `<html>`, `<head>`, or layout wrapper — so HTMX can swap it directly into `#page`.

**Result:** Navigation feels instant like a SPA, with real URL changes and browser history support, without writing JavaScript.

---

## Tailwind CSS

Tailwind CSS is loaded via the [Tailwind Play CDN](https://tailwindcss.com/docs/installation/play-cdn) — no `npm` or build step required.

The configuration in each layout file extends the default theme:

```html
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: { DEFAULT: '#6366f1', dark: '#4f46e5', light: '#a5b4fc' }
                },
                fontFamily: {
                    sans: ['Inter', 'ui-sans-serif', 'system-ui']
                }
            }
        }
    }
</script>
```

The `brand` color family (`brand`, `brand-dark`, `brand-light`) is available across all Tailwind classes: `bg-brand`, `text-brand-light`, `shadow-brand/30`, etc.

> **Production note:** The Play CDN is for development. For production, install the Tailwind CLI and compile a static CSS file to replace the CDN script.

---

*MonoPHP — Minimalist. Modern. PHP.*
