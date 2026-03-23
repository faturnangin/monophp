<p align="center">
  <div align="center" style="background:#6366f1; width:56px; height:56px; border-radius:14px; display: flex; align-items:center; justify-content:center; margin: 0 auto 16px;">
     <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M13 10V3L4 14h7v7l9-11h-7z"></path>
     </svg>
  </div>
  <h1 align="center" style="border:none;">MonoPHP</h1>
  <p align="center">A minimalist, experimental PHP framework combining modern architecture — routing, layouts, components, auth, and database queries — into a tiny codebase.</p>
</p>

## ✨ Features

- **Setup Wizard**: Out-of-the-box browser setup for URL, Environment, and Database Configuration.
- **Dynamic Routing & MVC**: Expressive `GET` & `POST` routes with named parameters. Supports Closures or auto-loaded `app/controllers/`.
- **Auth System**: Built-in login with password hashing and "Remember Me" sessions.
- **Database Wrapper**: Fluent PDO-based queries (`query()`, `first()`, `execute()`) with Multi-Database support.
- **Middleware**: Guard your application using global and route-specific middleware (`auth`, `guest`, `csrfProtection`).
- **Graceful Exceptions**: Intercepts fatal errors and CSRF violations to present beautiful 403 & 500 pages.
- **Tailwind CSS v4**: Built-in NPM pipeline for compiled design. No CDNs needed.
- **HTMX Integration**: Enjoy blazing-fast SPA navigation without writing JavaScript.
- **Asset Helper**: Smart CSS/JS paths with automatic MD5 Cache-Busting.
- **Layout System**: Wrap any page in a reusable HTML layout template instantly.
- **Component System**: Build UI with reusable JSX-like uppercase tags `<AlertBox />`.

---

## 🚀 Getting Started

MonoPHP aims to be a fully working application in under 60 seconds without digging into config files.

1. **Clone the repository:**
   ```bash
   git clone https://github.com/monophp/monophp.git
   cd monophp
   ```

2. **Serve the Application:**
   If using Laragon/XAMPP, your server is ready. If not, use PHP's built-in server:
   ```bash
   php -S localhost:8000 -t public
   ```

3. **Install & Compile Assets (Tailwind):**
   ```bash
   npm install
   npm run build
   ```
   *(For active development, run `npm run dev` to watch for CSS changes).*

4. **Run the Setup Wizard:**
   Open your browser to `http://localhost:8000` (or your local domain like `http://monophp.test`).
   MonoPHP will detect the missing `.env` file and redirect you to the **Installation Wizard**.
   * The Wizard will automatically create your Database tables (`users`, `remember_tokens`).
   * It will seed a default admin user: **email**: `admin@monophp.local` | **pass**: `password`.

---

## 📚 Core Documentation

The detailed framework documentation is available as a beautifully formatted web page built right into the app.

Once your setup is complete, navigate to:
**[http://localhost:8000/docs](/docs)**

There you will find a full guide on:
- How to structure your Routes and Middleware.
- Reading configs from the `.env` environment.
- Using `Database::first()` and `Auth::attempt()`.
- Building Layouts and HTMX swaps.

---

## 🏗️ Folder Structure

```text
monophp/
├── app/
│   ├── components/       # JSX-like UI elements (e.g. AlertBox.php)
│   ├── controllers/      # Optional MVC controllers (e.g. HomeController.php)
│   ├── layouts/          # HTML wrappers (main.php, auth.php, setup.php)
│   └── pages/            # View files mapped to routes (index.php, auth/login.php)
├── core/
│   ├── AssetHelper.php   # URL versioning for static files
│   ├── Auth.php          # Session and Remember Me management
│   ├── Database.php      # PDO Wrapper with Multi-DB & Transaction support
│   ├── Env.php           # Local .env configuration parser
│   ├── Middleware.php    # Request interceptors
│   ├── Router.php        # Core Routing engine
│   └── View.php          # Layout & content compiler
├── public/
│   ├── assets/           # Compiled CSS & JS (Tailwind & HTMX)
│   └── index.php         # The Entry Point! 
├── resources/
│   └── css/app.css       # Tailwind source file
└── package.json          # NPM scripts for Tailwind CSS
```

---

## 🛡️ Best Practices & Architecture

MonoPHP uses an `app/` structure reminiscent of file-based Next.js applications, but handles logic with the elegance of Laravel-like syntax.

**Security is a priority.** 
- All forms are protected by CSRF Tokens using `Middleware::csrfProtection()`.
- Passwords are encrypted using PHP's native `bcrypt` via `password_hash()`.
- SQL Queries use Prepared Statements and bindings through `Database::query("...", [$bindings])` to prevent SQL Injections.

---

**License:** MIT License. Free to use, fork, and hack apart.
