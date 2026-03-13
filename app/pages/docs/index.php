<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="flex flex-col md:flex-row gap-12 relative">
        
        <!-- Sidebar Navigation -->
        <aside class="w-full md:w-64 shrink-0 hidden md:block">
            <div class="sticky top-24">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Documentation</h3>
                <nav id="docs-sidebar" class="flex flex-col gap-1.5 border-l border-slate-800 pl-4 py-1">
                    <a href="#introduction" class="nav-item text-sm font-medium text-brand-light hover:text-white transition-colors py-1">Introduction</a>
                    <a href="#why-monophp" class="nav-item text-sm text-slate-400 hover:text-white transition-colors py-1">Why MonoPHP?</a>
                    <a href="#included-tech" class="nav-item text-sm text-slate-400 hover:text-white transition-colors py-1">What's Included</a>
                    <a href="#env-config" class="nav-item text-sm text-slate-400 hover:text-white transition-colors py-1">Environment Config</a>
                    <a href="#routing" class="nav-item text-sm text-slate-400 hover:text-white transition-colors py-1">Routing & Pages</a>
                    <a href="#views-layouts" class="nav-item text-sm text-slate-400 hover:text-white transition-colors py-1">Views & Layouts</a>
                    <a href="#asset-helper" class="nav-item text-sm text-slate-400 hover:text-white transition-colors py-1">Asset Helper</a>
                    <a href="#database-auth" class="nav-item text-sm text-slate-400 hover:text-white transition-colors py-1">Database & Auth</a>
                    <a href="#middleware" class="nav-item text-sm text-slate-400 hover:text-white transition-colors py-1">Middleware</a>
                </nav>
            </div>
        </aside>

        <!-- Content -->
        <article class="prose prose-invert prose-brand max-w-none w-full pb-32" id="docs-content">
            <h1 class="text-4xl font-extrabold mb-8 tracking-tight">MonoPHP Documentation</h1>
            
            <section id="introduction" class="pt-8 scroll-mt-24">
                <h2>Introduction</h2>
                <p class="lead">
                    Welcome to <strong>MonoPHP</strong> — the minimalist framework built for developers who want the 
                    architecture of a modern ecosystem without the bloat. 
                </p>
                <p>
                    MonoPHP was born out of a desire for simplicity. Often, we find ourselves setting up massive 
                    frameworks just to build a simple, robust application. MonoPHP strips away the magic, leaving you 
                    with a core that is incredibly fast, immediately readable, and highly maintainable.
                </p>
                <p>
                    From automatic environment setups using our built-in Setup Wizard, to seamlessly integrated 
                    Tailwind CSS compilation, MonoPHP gets your environment ready in less than a minute.
                </p>
            </section>

            <section id="why-monophp" class="pt-8 scroll-mt-24">
                <h2>Why MonoPHP?</h2>
                <p>
                    We designed this framework to feel <strong>familiar yet remarkably lightweight</strong>. If you look at the 
                    codebase, you will see a structured <code>app/</code> folder reminiscent of <strong>Next.js</strong> — neatly 
                    separating <code>pages</code>, <code>layouts</code>, and <code>components</code>. 
                </p>
                <p>
                    Simultaneously, the framework is heavily inspired by <strong>Laravel's elegance</strong>. You get highly 
                    expressive facades and helpers:
                </p>
                <ul>
                    <li><code>Auth::attempt()</code> and <code>Auth::user()</code> for drop-in authentication.</li>
                    <li><code>Database::first()</code> for fluent, PDO-wrapper SQL queries.</li>
                    <li>Global and route-specific <code>Middleware</code> pipelines.</li>
                    <li>An intuitive <code>Env::get()</code> manager.</li>
                </ul>
                <p>
                    It brings all these enterprise-level patterns into a codebase so small, <em>you can read the entire 
                    source code in an afternoon</em>. 
                </p>
            </section>

            <section id="included-tech" class="pt-8 scroll-mt-24">
                <h2>What's Included</h2>
                <p>
                    MonoPHP stands on the shoulders of giants. We have pre-configured two of the most powerful modern 
                    web tools directly into the core, saving you hours of configuration:
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 not-prose mt-6">
                    <div class="card p-5 border-brand/20 bg-brand/5">
                        <div class="text-brand-light font-semibold mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.337 13.382 8.976 12 6.001 12z"/>
                            </svg>
                            Tailwind CSS v4
                        </div>
                        <p class="text-sm text-slate-400">
                            Fully integrated local NPM build pipeline. No CDNs. It's pre-configured with typography plugins, 
                            custom components (<code>.btn</code>, <code>.card</code>), and intelligent cache-busting via <code>AssetHelper</code>.
                        </p>
                    </div>
                    <div class="card p-5 border-emerald-500/20 bg-emerald-500/5">
                        <div class="text-emerald-400 font-semibold mb-2 flex items-center gap-2">
                            <span class="text-lg">&lt;/&gt;</span> HTMX
                        </div>
                        <p class="text-sm text-slate-400">
                            Enjoy the blazing-fast UX of a Single Page Application (SPA) without writing a single line of React 
                            or Vue. MonoPHP uses HTMX to swap layouts instantly, making page loads feel weightless.
                        </p>
                    </div>
                </div>
            </section>

            <hr class="divider">

            <section id="env-config" class="pt-8 scroll-mt-24">
                <h2>Environment Config</h2>
                <p>
                    MonoPHP uses an <code>.env</code> file parser in <code>core/Env.php</code> to manage application secrets. 
                    It automatically string-casts common boolean words and numeric values.
                </p>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto border border-slate-700/50 my-4">
                    <pre class="!m-0"><code class="language-php text-sm text-slate-300"><span class="text-slate-500">// Read from .env, falling back to false if missing</span>
<span class="text-brand-light">$debugMode</span> = <span class="text-brand-light">Env</span>::get(<span class="text-emerald-300">'APP_DEBUG'</span>, <span class="text-blue-300">false</span>);

<span class="text-slate-500">// Get raw values</span>
<span class="text-brand-light">$appName</span> = <span class="text-brand-light">Env</span>::get(<span class="text-emerald-300">'APP_NAME'</span>, <span class="text-emerald-300">'MonoPHP'</span>);</code></pre>
                </div>
            </section>

            <hr class="divider">

            <section id="routing" class="pt-8 scroll-mt-24">
                <h2>Routing & Pages</h2>
                <p>
                    Routes are defined in the central <code>public/index.php</code> file. The router parses URLs and maps 
                    them to your page files stored in <code>app/pages/</code>.
                </p>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto border border-slate-700/50">
                    <pre class="!m-0"><code class="language-php text-sm text-slate-300"><span class="text-brand-light">$router</span>->get(<span class="text-emerald-300">'/products'</span>, function() {
    <span class="text-brand-light">View</span>::render(<span class="text-emerald-300">'products/index'</span>, [], <span class="text-emerald-300">'main'</span>);
});

<span class="text-slate-500">// Dynamic parameters are supported!</span>
<span class="text-brand-light">$router</span>->get(<span class="text-emerald-300">'/users/{id}'</span>, function(<span class="text-brand-light">$params</span>) {
    <span class="text-brand-light">$user</span> = <span class="text-brand-light">Database</span>::first(<span class="text-emerald-300">"SELECT * FROM users WHERE id = ?"</span>, [<span class="text-brand-light">$params</span>[<span class="text-emerald-300">'id'</span>]]);
    <span class="text-brand-light">View</span>::render(<span class="text-emerald-300">'users/show'</span>, [<span class="text-emerald-300">'user'</span> => <span class="text-brand-light">$user</span>], <span class="text-emerald-300">'main'</span>);
});</code></pre>
                </div>
            </section>

            <section id="views-layouts" class="pt-8 scroll-mt-24">
                <h2>Views & Layouts</h2>
                <p>
                    When you call <code>View::render('products/index', [], 'main')</code>, the framework looks for:
                    <ol>
                        <li><code>app/pages/products/index.php</code> (The View)</li>
                        <li><code>app/layouts/main.php</code> (The Layout)</li>
                    </ol>
                </p>
                <div class="alert-info mt-4">
                    <strong>HTMX Magic:</strong> If the request was made via HTMX (like clicking an <code>hx-get</code> link), 
                    MonoPHP automatically detects the <code>HX-Request</code> header and skips loading the full Layout. 
                    It only returns the raw View HTML, creating an instant swap.
                </div>
            </section>

            <hr class="divider">

            <section id="asset-helper" class="pt-8 scroll-mt-24">
                <h2>Asset Helper</h2>
                <p>
                    MonoPHP abstracts static asset delivery using the <code>AssetHelper</code> class. 
                    This ensures assets are safely referenced regardless of subfolder deployment (e.g. Laragon) 
                    and provides automatic cache-busting using an MD5 hash of your files.
                </p>
                
                <h3>Linking CSS & JS</h3>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto border border-slate-700/50 my-4">
                    <pre class="!m-0"><code class="language-php text-sm text-slate-300">&lt;?= <span class="text-brand-light">AssetHelper</span>::css(<span class="text-emerald-300">'css/app.css'</span>) ?&gt;
&lt;?= <span class="text-brand-light">AssetHelper</span>::js(<span class="text-emerald-300">'js/htmx.min.js'</span>, [<span class="text-emerald-300">'defer'</span> => <span class="text-blue-300">true</span>]) ?&gt;</code></pre>
                </div>

                <h3>Getting Raw URLs</h3>
                <p>If you need the path for images or raw links, use <code>url()</code>:</p>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto border border-slate-700/50 my-4">
                    <pre class="!m-0"><code class="language-php text-sm text-slate-300">&lt;img src="&lt;?= <span class="text-brand-light">AssetHelper</span>::url(<span class="text-emerald-300">'img/logo.png'</span>) ?&gt;" alt="Logo"&gt;</code></pre>
                </div>
                <p>The resulting URL will look like: <code>/assets/img/logo.png?v=a3f1b2c4</code></p>
            </section>

            <section id="database-auth" class="pt-8 scroll-mt-24">
                <h2>Database & Authentication</h2>
                
                <h3>Database Queries</h3>
                <p>
                    The <code>Database</code> class uses a singleton PDO connection. Configure your credentials via the Setup Wizard 
                    (which writes to your <code>.env</code> file) and query safely using bindings:
                </p>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto border border-slate-700/50 my-4">
                    <pre class="!m-0"><code class="language-php text-sm text-slate-300"><span class="text-brand-light">$allUsers</span> = <span class="text-brand-light">Database</span>::query(<span class="text-emerald-300">"SELECT * FROM users"</span>);
<span class="text-brand-light">$oneUser</span>  = <span class="text-brand-light">Database</span>::first(<span class="text-emerald-300">"SELECT * FROM users WHERE email = ?"</span>, [<span class="text-brand-light">$email</span>]);
<span class="text-brand-light">$newId</span>    = <span class="text-brand-light">Database</span>::insert(<span class="text-emerald-300">"INSERT INTO posts (title) VALUES (?)"</span>, [<span class="text-brand-light">$title</span>]);</code></pre>
                </div>

                <h3>Authentication</h3>
                <p>
                    The built-in <code>Auth</code> class handles passwords (hashing via <code>bcrypt</code>), session management, 
                    and "Remember Me" cookies spanning 30 days.
                </p>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto border border-slate-700/50 my-4">
                    <pre class="!m-0"><code class="language-php text-sm text-slate-300"><span class="text-slate-500">// Attempt Login</span>
<span class="text-blue-300">if</span> (<span class="text-brand-light">Auth</span>::attempt(<span class="text-brand-light">$email</span>, <span class="text-brand-light">$password</span>, <span class="text-brand-light">$rememberToken</span>)) {
    <span class="text-blue-300">echo</span> <span class="text-emerald-300">"Welcome "</span> . <span class="text-brand-light">Auth</span>::user()[<span class="text-emerald-300">'name'</span>];
}

<span class="text-slate-500">// Check if logged in</span>
<span class="text-blue-300">if</span> (!<span class="text-brand-light">Auth</span>::check()) { <span class="text-brand-light">Auth</span>::logout(); }</code></pre>
                </div>
            </section>

            <hr class="divider">

            <section id="middleware" class="pt-8 scroll-mt-24">
                <h2>Middleware</h2>
                <p>
                    Middleware in MonoPHP intercepts incoming traffic. They can be registered globally or assigned directly to routes.
                    Middleware functions receive the HTTP <code>$method</code> and <code>$uri</code>, and must return <code>true</code> to pass, or redirect/block and return <code>false</code>.
                </p>
                <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto border border-slate-700/50 my-4">
                    <pre class="!m-0"><code class="language-php text-sm text-slate-300"><span class="text-slate-500">// Global Pipeline (in public/index.php)</span>
<span class="text-brand-light">$router</span>->use(<span class="text-brand-light">Middleware</span>::csrfProtection());

<span class="text-slate-500">// Route-Specific Middleware Execution</span>
<span class="text-brand-light">$router</span>->get(<span class="text-emerald-300">'/dashboard'</span>, function() {
    <span class="text-slate-500">// Executes the guard before rendering</span>
    <span class="text-brand-light">Middleware</span>::auth()(<span class="text-emerald-300">'GET'</span>, <span class="text-emerald-300">'/dashboard'</span>); 
    
    <span class="text-brand-light">View</span>::render(<span class="text-emerald-300">'dashboard'</span>, [], <span class="text-emerald-300">'main'</span>);
});</code></pre>
                </div>
                
                <h3>Built-in Middleware</h3>
                <ul class="list-disc pl-5 mt-4 space-y-2 text-slate-300">
                    <li><code>Middleware::csrfProtection()</code> — Protects POST routes by verifying <code>$_POST['_csrf_token']</code> against the Session token.</li>
                    <li><code>Middleware::setupGuard()</code> — Redirects users to the Installation Wizard if <code>APP_SETUP</code> is missing.</li>
                    <li><code>Middleware::auth()</code> — Block unauthenticated users.</li>
                    <li><code>Middleware::guest()</code> — Redirect logged-in users away from Auth pages (like `/login`).</li>
                </ul>
            </section>

            <div class="mt-16 pt-8 border-t border-slate-800 text-center">
                <a href="/" hx-get="/" hx-target="#page" hx-push-url="true" class="btn-primary">
                    ← Back to Home
                </a>
            </div>

        </article>
    </div>
</div>

<script>
    // Intersection Observer for Sidebar Active State
    document.addEventListener('DOMContentLoaded', () => {
        initDocsSidebar();
    });

    // Also run on HTMX load so SPA navigation doesn't break the script
    document.addEventListener('htmx:afterSettle', () => {
        if(document.getElementById('docs-sidebar')) {
            initDocsSidebar();
        }
    });

    function initDocsSidebar() {
        const sections = document.querySelectorAll('#docs-content section');
        const navItems = document.querySelectorAll('#docs-sidebar .nav-item');

        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -60% 0px', // Trigger when section is near top
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    
                    // Remove active styles from all
                    navItems.forEach(item => {
                        item.classList.remove('text-brand-light');
                        item.classList.add('text-slate-400');
                        item.classList.remove('border-l-2', 'border-brand-light', '-ml-[17px]', 'pl-[15px]');
                    });

                    // Add active style to current
                    const activeItem = document.querySelector(`#docs-sidebar a[href="#${id}"]`);
                    if (activeItem) {
                        activeItem.classList.remove('text-slate-400');
                        activeItem.classList.add('text-brand-light', 'border-l-2', 'border-brand-light', '-ml-[17px]', 'pl-[15px]');
                    }
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            observer.observe(section);
        });
    }
</script>
