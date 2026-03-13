<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars(Env::get('APP_NAME', 'MonoPHP')) ?></title>
    
    <!-- Compiled Assets -->
    <?= AssetHelper::css('css/app.css') ?>
    <?= AssetHelper::js('js/htmx.min.js', ['defer' => true]) ?>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 font-sans">

    <!-- Navbar -->
    <nav class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <!-- Logo -->
            <a href="/" hx-get="/" hx-target="#page" hx-push-url="true"
               class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-xl bg-brand flex items-center justify-center shadow-md shadow-brand/40 group-hover:scale-105 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-lg font-bold tracking-tight">
                    <?= htmlspecialchars(Env::get('APP_NAME', 'MonoPHP')) ?>
                </span>
            </a>

            <!-- Nav links -->
            <div class="flex items-center gap-1">
                <a href="/docs" hx-get="/docs" hx-target="#page" hx-push-url="true" class="nav-link">
                    Docs
                </a>
                
                <?php if (Auth::check()): ?>
                    <a href="/dashboard" hx-get="/dashboard" hx-target="#page" hx-push-url="true" class="nav-link text-brand-light">
                        Dashboard
                    </a>
                    <a href="/logout" class="nav-link hover:text-red-400">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="/login" hx-get="/login" hx-target="#page" hx-push-url="true" class="nav-link">
                        Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Page content -->
    <main id="page" class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800 mt-16 py-6 text-center text-slate-600 text-sm">
        <?= htmlspecialchars(Env::get('APP_NAME', 'MonoPHP')) ?> &mdash; Minimalist PHP Framework
    </footer>

</body>
</html>
