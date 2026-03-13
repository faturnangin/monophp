<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Authentication &mdash; <?= htmlspecialchars(Env::get('APP_NAME', 'MonoPHP')) ?></title>
    
    <!-- Compiled Assets -->
    <?= AssetHelper::css('css/app.css') ?>
    <?= AssetHelper::js('js/htmx.min.js', ['defer' => true]) ?>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center p-4">

    <div class="w-full max-w-sm absolute top-8 left-8">
        <a href="/" hx-get="/" hx-target="body" hx-push-url="true"
           class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Home
        </a>
    </div>

    <div class="w-full max-w-md" id="page">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-brand shadow-lg shadow-brand/40 mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold tracking-tight">Welcome Back</h1>
            <p class="text-slate-400 text-sm mt-1">Sign in to your account to continue</p>
        </div>

        <?= $content ?>
    </div>

</body>
</html>
