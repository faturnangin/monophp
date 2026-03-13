<?php $currentStep = 4; ?>

<div class="p-8 md:p-10 text-center">

    <!-- Success icon -->
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-500/20 border border-emerald-500/30 mb-6">
        <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <h1 class="text-3xl font-bold mb-3">Setup Complete!</h1>
    <p class="text-slate-400 mb-8 max-w-md mx-auto leading-relaxed">
        Your <strong class="text-white"><?= htmlspecialchars(Env::get('APP_NAME', 'MonoPHP')) ?></strong>
        application has been configured successfully. Your <code class="text-brand-light text-sm bg-slate-900 px-1.5 py-0.5 rounded">.env</code>
        file has been created in the project root.
    </p>

    <!-- Summary -->
    <div class="bg-slate-900/70 border border-slate-700/50 rounded-2xl p-5 text-left max-w-md mx-auto mb-8 space-y-3">
        <?php
        $summary = [
            ['icon' => '🏷️', 'label' => 'App Name',    'value' => Env::get('APP_NAME', '—')],
            ['icon' => '🌐', 'label' => 'URL',          'value' => Env::get('APP_URL', '—')],
            ['icon' => '⚙️', 'label' => 'Environment',  'value' => ucfirst(Env::get('APP_ENV', '—'))],
            ['icon' => '🗄️', 'label' => 'Database',     'value' => Env::get('DB_DATABASE') ? Env::get('DB_HOST') . '/' . Env::get('DB_DATABASE') : 'Not configured'],
        ];
        foreach ($summary as $item): ?>
        <div class="flex items-center justify-between text-sm">
            <span class="text-slate-500"><?= $item['icon'] ?> <?= $item['label'] ?></span>
            <span class="text-slate-200 font-medium"><?= htmlspecialchars($item['value']) ?></span>
        </div>
        <?php endforeach; ?>
    </div>

    <a href="/"
       class="inline-flex items-center gap-2 px-8 py-3.5 rounded-2xl bg-brand hover:bg-brand-dark text-white font-semibold shadow-lg shadow-brand/30 hover:shadow-brand/50 transition-all hover:-translate-y-0.5">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Go to Dashboard
    </a>
</div>
