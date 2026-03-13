<!-- app/pages/errors/404.php -->
<div class="flex flex-col items-center justify-center py-24 text-center">
    <p class="text-8xl font-extrabold text-slate-700 mb-4">404</p>
    <h1 class="text-2xl font-bold text-white mb-2">Page Not Found</h1>
    <p class="text-slate-400 mb-8">The page you're looking for doesn't exist.</p>
    <a hx-get="/" hx-target="#page" hx-push-url="true"
       class="px-6 py-3 rounded-2xl bg-brand text-white font-semibold text-sm hover:bg-brand-dark transition-all cursor-pointer shadow-lg shadow-brand/30">
        ← Back to Home
    </a>
</div>
