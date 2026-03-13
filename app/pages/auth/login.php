<div class="card shadow-2xl">
    <div class="card-body p-8">

        <?php if (isset($error)): ?>
            <div class="alert-error mb-6 flex items-start gap-3">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="/login" class="space-y-5">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_SESSION['_csrf_token'] ?? '') ?>">

            <div>
                <label for="email" class="form-label">Email Address</label>
                <input id="email" name="email" type="email" required autofocus
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       class="form-input" placeholder="admin@monophp.local">
            </div>

            <div>
                <label for="password" class="form-label">Password</label>
                <input id="password" name="password" type="password" required
                       class="form-input" placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <div class="relative flex items-center justify-center w-5 h-5">
                        <input type="checkbox" name="remember" value="1" 
                               class="peer sr-only">
                        <div class="w-5 h-5 rounded border border-slate-600 bg-slate-900 peer-checked:bg-brand peer-checked:border-brand transition-all"></div>
                        <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-sm text-slate-400 group-hover:text-slate-300 transition-colors">Remember me</span>
                </label>
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3">
                Sign In
            </button>
        </form>

    </div>
</div>
