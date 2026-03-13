<?php $currentStep = 1; ?>

<div class="p-8 md:p-10">
    <!-- Icon -->
    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-brand to-purple-700 flex items-center justify-center mb-6 shadow-lg shadow-brand/30">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
    </div>

    <h1 class="text-3xl font-bold mb-3">Welcome to MonoPHP</h1>
    <p class="text-slate-400 mb-6 leading-relaxed">
        This setup wizard will help you configure your application in just a few steps.
        Before we begin, please make sure your server meets the following requirements.
    </p>

    <!-- Requirements check -->
    <div class="space-y-3 mb-8">
        <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider">System Requirements</h2>
        <?php
        $checks = [
            ['label' => 'PHP 8.1 or higher', 'pass' => version_compare(PHP_VERSION, '8.1.0', '>='), 'info' => 'PHP ' . PHP_VERSION],
            ['label' => 'Writable root directory', 'pass' => is_writable(__DIR__ . '/../../../'), 'info' => 'For .env creation'],
        ];
        foreach ($checks as $check): ?>
        <div class="flex items-center justify-between px-4 py-3 rounded-xl
            <?= $check['pass'] ? 'bg-emerald-950/50 border border-emerald-800/40' : 'bg-red-950/50 border border-red-800/40' ?>">
            <div class="flex items-center gap-3">
                <?php if ($check['pass']): ?>
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                <?php else: ?>
                    <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                <?php endif; ?>
                <span class="text-sm font-medium <?= $check['pass'] ? 'text-emerald-300' : 'text-red-300' ?>">
                    <?= htmlspecialchars($check['label']) ?>
                </span>
            </div>
            <span class="text-xs text-slate-500"><?= htmlspecialchars($check['info']) ?></span>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- CTA -->
    <div class="flex justify-end">
        <a href="/setup/configure"
           class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-brand hover:bg-brand-dark text-white font-semibold text-sm shadow-lg shadow-brand/30 hover:shadow-brand/50 transition-all hover:-translate-y-0.5">
            Let's Get Started
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>
