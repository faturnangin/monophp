<!-- app/pages/index.php -->
<div class="py-16 text-center">
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-brand to-purple-700 mb-8 shadow-2xl shadow-brand/30">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
    </div>

    <h1 class="text-5xl font-extrabold mb-4 bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">
        Welcome to MonoPHP
    </h1>
    <p class="text-slate-400 text-lg mb-10 max-w-xl mx-auto leading-relaxed">
        A minimalist PHP framework with routing, layouts, components, auth, and HTMX-powered navigation.
    </p>

    <div class="flex flex-wrap items-center justify-center gap-4 mb-16">
        <a hx-get="/docs" hx-target="#page" hx-push-url="true"
           class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            Documentation
        </a>
        <a href="https://github.com/faturnangin/monophp" target="_blank"
           class="btn-ghost">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2A10 10 0 002 12c0 4.42 2.87 8.17 6.84 9.5.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.45-1.15-1.11-1.46-1.11-1.46-.9-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.87 1.52 2.34 1.07 2.91.83.09-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.92 0-1.11.38-2 1.03-2.71-.1-.25-.45-1.29.1-2.64 0 0 .84-.27 2.75 1.02.79-.22 1.65-.33 2.5-.33.85 0 1.71.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.35.2 2.39.1 2.64.65.71 1.03 1.6 1.03 2.71 0 3.82-2.34 4.66-4.57 4.91.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0012 2z"/>
            </svg>
            GitHub
        </a>
    </div>

    <!-- Feature cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-left">
        <?php
        $features = [
            ['icon' => '🔀', 'title' => 'Dynamic Routing',     'desc' => 'Full RESTful routing (GET, POST, PUT, DELETE) with parameters.'],
            ['icon' => '🎨', 'title' => 'Layout System',       'desc' => 'Wrap any page in a reusable HTML layout template.'],
            ['icon' => '🧩', 'title' => 'Components',          'desc' => 'Reusable JSX-like components using uppercase tags.'],
            ['icon' => '🛡️', 'title' => 'Middleware',          'desc' => 'Global and route-specific guards for protection.'],
            ['icon' => '🔐', 'title' => 'Auth System',         'desc' => 'Built-in session-based login with password hashing.'],
            ['icon' => '🗃️', 'title' => 'Database (PDO)',      'desc' => 'Fluent SQL querying with a singleton PDO wrapper.'],
            ['icon' => '⚡', 'title' => 'HTMX Navigation',     'desc' => 'SPA-like navigation without writing a single line of JS.'],
            ['icon' => '📦', 'title' => 'Asset Helper',        'desc' => 'Automatic MD5 cache-busting for your compiled CSS/JS.'],
        ];
        foreach ($features as $f): ?>
        <div class="card p-5 group hover:border-brand/40 transition-colors duration-300">
            <div class="text-2xl mb-3"><?= $f['icon'] ?></div>
            <h3 class="text-sm font-semibold text-white mb-1 group-hover:text-brand-light transition-colors"><?= $f['title'] ?></h3>
            <p class="text-xs text-slate-500 leading-relaxed"><?= $f['desc'] ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>