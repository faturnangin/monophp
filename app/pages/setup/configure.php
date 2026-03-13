<?php $currentStep = 2; ?>

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
    <h1 class="text-2xl font-bold mb-1">Application Settings</h1>
    <p class="text-slate-400 text-sm mb-8">Configure the basic settings for your application.</p>

    <form method="POST" action="/setup/configure" class="space-y-6">
        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($_SESSION['_csrf_token'] ?? '') ?>" />

        <!-- App Name -->
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2" for="app_name">Application Name</label>
            <input id="app_name" name="app_name" type="text" required
                   value="<?= htmlspecialchars($old['app_name'] ?? 'MonoPHP') ?>"
                   placeholder="My Awesome App"
                   class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-600
                          focus:outline-none focus:ring-2 focus:ring-brand/60 focus:border-brand transition-all text-sm" />
        </div>

        <!-- App URL -->
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2" for="app_url">Application URL</label>
            <input id="app_url" name="app_url" type="url" required
                   value="<?= htmlspecialchars($old['app_url'] ?? 'http://localhost') ?>"
                   placeholder="http://localhost"
                   class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-600
                          focus:outline-none focus:ring-2 focus:ring-brand/60 focus:border-brand transition-all text-sm" />
        </div>

        <!-- Environment -->
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2" for="app_env">Environment</label>
            <select id="app_env" name="app_env"
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white
                           focus:outline-none focus:ring-2 focus:ring-brand/60 focus:border-brand transition-all text-sm">
                <?php foreach (['local', 'development', 'staging', 'production'] as $env): ?>
                    <option value="<?= $env ?>" <?= ($old['app_env'] ?? 'local') === $env ? 'selected' : '' ?>>
                        <?= ucfirst($env) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Debug mode -->
        <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-slate-900 border border-slate-700">
            <div>
                <p class="text-sm font-medium text-slate-200">Debug Mode</p>
                <p class="text-xs text-slate-500 mt-0.5">Show detailed error messages (disable in production)</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="app_debug" value="true" class="sr-only peer"
                       <?= isset($old['app_debug']) ? 'checked' : 'checked' ?>>
                <div class="w-10 h-6 bg-slate-700 peer-focus:ring-2 peer-focus:ring-brand/40 rounded-full peer
                            peer-checked:bg-brand after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                            after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all
                            peer-checked:after:translate-x-4"></div>
            </label>
        </div>

        <!-- Navigation -->
        <div class="flex items-center justify-between pt-2">
            <a href="/setup" class="text-sm text-slate-500 hover:text-slate-300 transition-colors">← Back</a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-brand hover:bg-brand-dark text-white font-semibold text-sm shadow-lg shadow-brand/30 hover:shadow-brand/50 transition-all hover:-translate-y-0.5">
                Next: Database
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </form>
</div>
