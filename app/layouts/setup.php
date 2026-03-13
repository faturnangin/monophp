<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Setup &mdash; <?= htmlspecialchars(Env::get('APP_NAME', 'MonoPHP')) ?></title>
    
    <!-- Compiled Assets -->
    <?= AssetHelper::css('css/app.css') ?>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-950 to-slate-900 text-white flex items-center justify-center p-4">

    <div class="w-full max-w-2xl">

        <!-- Logo -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-brand flex items-center justify-center shadow-lg shadow-brand/40">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold tracking-tight">Mono<span class="text-brand-light">PHP</span></span>
            </div>
            <p class="text-slate-400 text-sm">Framework Setup Wizard</p>
        </div>

        <!-- Step progress -->
        <div class="flex items-center justify-center gap-2 mb-8">
            <?php
            $steps = ['Welcome', 'Application', 'Database', 'Complete'];
            foreach ($steps as $i => $label):
                $num       = $i + 1;
                $isCurrent = $num === ($currentStep ?? 1);
                $isDone    = $num < ($currentStep ?? 1);
            ?>
            <?php if ($i > 0): ?>
                <div class="flex-1 h-px <?= $isDone ? 'bg-brand' : 'bg-slate-700' ?> max-w-[60px]"></div>
            <?php endif; ?>
            <div class="flex flex-col items-center gap-1">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold transition-all
                    <?= $isDone    ? 'bg-brand text-white' :
                       ($isCurrent ? 'bg-brand text-white ring-4 ring-brand/30' :
                                     'bg-slate-800 text-slate-500 border border-slate-700') ?>">
                    <?php if ($isDone): ?>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    <?php else: ?>
                        <?= $num ?>
                    <?php endif; ?>
                </div>
                <span class="text-xs <?= $isCurrent ? 'text-brand-light font-medium' : 'text-slate-500' ?>"><?= $label ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Card -->
        <div class="card overflow-hidden shadow-2xl">
            <?= $content ?>
        </div>

    </div>

</body>
</html>
