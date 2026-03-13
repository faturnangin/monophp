<?php $currentStep = 3; ?>

<?php if (isset($errors) && count($errors) > 0): ?>
<div class="bg-red-950/60 border-b border-red-800/40 px-8 py-4">
    <p class="text-sm font-semibold text-red-400 mb-1">Please fix the following errors:</p>
    <ul class="list-disc list-inside text-sm text-red-300 space-y-0.5">
        <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="p-8 md:p-10">
    <h1 class="text-2xl font-bold mb-1">Database Connection</h1>
    <p class="text-slate-400 text-sm mb-8">Enter your database credentials. You can skip this step if you won't use a database.</p>

    <form method="POST" action="/setup/database" class="space-y-6">
        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_SESSION['_csrf_token'] ?? '') ?>" />

        <!-- Host + Port -->
        <div class="grid grid-cols-3 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-300 mb-2" for="db_host">Host</label>
                <input id="db_host" name="db_host" type="text"
                       value="<?= htmlspecialchars($old['db_host'] ?? '127.0.0.1') ?>"
                       placeholder="127.0.0.1"
                       class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-600
                              focus:outline-none focus:ring-2 focus:ring-brand/60 focus:border-brand transition-all text-sm" />
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2" for="db_port">Port</label>
                <input id="db_port" name="db_port" type="number"
                       value="<?= htmlspecialchars($old['db_port'] ?? '3306') ?>"
                       placeholder="3306"
                       class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-600
                              focus:outline-none focus:ring-2 focus:ring-brand/60 focus:border-brand transition-all text-sm" />
            </div>
        </div>

        <!-- Database name -->
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2" for="db_database">Database Name</label>
            <input id="db_database" name="db_database" type="text"
                   value="<?= htmlspecialchars($old['db_database'] ?? '') ?>"
                   placeholder="MonoPHP"
                   class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-600
                          focus:outline-none focus:ring-2 focus:ring-brand/60 focus:border-brand transition-all text-sm" />
        </div>

        <!-- Username + Password -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2" for="db_username">Username</label>
                <input id="db_username" name="db_username" type="text"
                       value="<?= htmlspecialchars($old['db_username'] ?? 'root') ?>"
                       placeholder="root"
                       class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-600
                              focus:outline-none focus:ring-2 focus:ring-brand/60 focus:border-brand transition-all text-sm" />
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2" for="db_password">Password</label>
                <input id="db_password" name="db_password" type="password"
                       placeholder="(leave blank if none)"
                       class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-600
                              focus:outline-none focus:ring-2 focus:ring-brand/60 focus:border-brand transition-all text-sm" />
            </div>
        </div>

        <?php if (isset($connectionError)): ?>
        <div class="flex items-center gap-2 px-4 py-3 rounded-xl bg-red-950/60 border border-red-800/40">
            <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-red-300"><?= htmlspecialchars($connectionError) ?></p>
        </div>
        <?php endif; ?>

        <!-- Navigation -->
        <div class="flex items-center justify-between pt-2">
            <a href="/setup/configure" class="text-sm text-slate-500 hover:text-slate-300 transition-colors">← Back</a>
            <div class="flex gap-3">
                <a href="/setup/complete?skip_db=1"
                   class="px-5 py-2.5 rounded-2xl border border-slate-600 text-slate-400 hover:text-white hover:border-slate-500 text-sm font-medium transition-all">
                    Skip
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-brand hover:bg-brand-dark text-white font-semibold text-sm shadow-lg shadow-brand/30 hover:shadow-brand/50 transition-all hover:-translate-y-0.5">
                    Save & Continue
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
    </form>
</div>
