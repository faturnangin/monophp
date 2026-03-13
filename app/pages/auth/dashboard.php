<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <p class="text-slate-400 mt-1">Welcome back, <?= htmlspecialchars(Auth::user()['name']) ?>!</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Profile Card -->
    <div class="card h-full">
        <div class="card-body">
            <h2 class="text-lg font-semibold mb-4 text-white">Your Profile</h2>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between py-2 border-b border-slate-700/50">
                    <span class="text-slate-400 text-sm">Name</span>
                    <span class="text-white font-medium"><?= htmlspecialchars(Auth::user()['name']) ?></span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-slate-700/50">
                    <span class="text-slate-400 text-sm">Email</span>
                    <span class="text-white font-medium"><?= htmlspecialchars(Auth::user()['email']) ?></span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-slate-400 text-sm">Role</span>
                    <span class="badge-brand">Administrator</span>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="card h-full">
        <div class="card-body">
            <h2 class="text-lg font-semibold mb-4 text-white">System Status</h2>
            
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-900/40 border border-emerald-800/40 flex items-center justify-center text-emerald-400 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">Database Connected</p>
                        <p class="text-xs text-slate-400">MySQL Server / PDO</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center text-brand-light shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">Authentication Active</p>
                        <p class="text-xs text-slate-400">Session ID: <?= substr(session_id(), 0, 8) ?>...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
