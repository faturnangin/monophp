<div class="card shadow-2xl overflow-hidden max-w-2xl mx-auto my-16">
    <div class="h-2 bg-gradient-to-r from-red-500 to-rose-500"></div>
    <div class="card-body p-8 sm:p-12 text-center">
        
        <div class="mx-auto w-24 h-24 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight mb-4">403</h1>
        <h2 class="text-xl sm:text-2xl font-semibold text-slate-300 mb-6">Forbidden Request</h2>
        
        <p class="text-slate-400 mb-8 max-w-md mx-auto">
            You don't have permission to access the requested resource. This is usually caused by an expired session or CSRF token mismatch.
        </p>

        <a href="/" hx-get="/" hx-target="#page" hx-push-url="true" class="btn-primary inline-flex">
            Return to Homepage
        </a>

    </div>
</div>
