<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Laravel Web Deployment Script
|--------------------------------------------------------------------------
|
| Place this file in:   public/deploy.php
| Then visit:           https://your-domain.com/deploy.php?key=YOUR_KEY
|
| The script deletes itself after a successful run.
| If it cannot, DELETE IT MANUALLY.
|
*/

use Illuminate\Contracts\Console\Kernel;

// ---------------------------------------------------------------------
// SECURITY
// ---------------------------------------------------------------------

// Long random key. Change it if it was ever shared or logged.
$secret = '064983066e22f87ec290cdb1345b57cf0542695d443dded0';

header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-store');
header('X-Robots-Tag: noindex, nofollow');

if (
    !isset($_GET['key']) ||
    !hash_equals($secret, (string) $_GET['key'])
) {
    usleep(500000); // slow down guessing
    http_response_code(403);
    exit('Forbidden');
}

@set_time_limit(300);
@ini_set('display_errors', '1');
error_reporting(E_ALL);

register_shutdown_function(function () {
    $e = error_get_last();
    if ($e) {
        echo '<pre style="color:red">' . htmlspecialchars(print_r($e, true)) . '</pre>';
    }
});


// ---------------------------------------------------------------------
// BOOTSTRAP LARAVEL
// ---------------------------------------------------------------------

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();


// ---------------------------------------------------------------------
// HELPERS
// ---------------------------------------------------------------------

function runCommand(
    Kernel $kernel,
    string $command,
    array $parameters = []
): array {
    echo '<h3>' . htmlspecialchars($command) . '</h3>';

    try {
        $exitCode = $kernel->call($command, $parameters);
        $output = $kernel->output();

        echo '<pre>';
        echo htmlspecialchars($output ?: '(no output)');
        echo '</pre>';

        if ($exitCode !== 0) {
            echo '<p style="color:red"><strong>FAILED</strong> — Exit code: '
                . $exitCode
                . '</p>';

            return ['success' => false, 'exit_code' => $exitCode, 'output' => $output];
        }

        echo '<p style="color:green"><strong>OK</strong></p>';

        return ['success' => true, 'exit_code' => $exitCode, 'output' => $output];
    } catch (Throwable $e) {

        echo '<pre style="color:red">';
        echo htmlspecialchars(get_class($e) . ': ' . $e->getMessage());
        echo "\n\n";
        echo htmlspecialchars($e->getTraceAsString());
        echo '</pre>';

        return ['success' => false, 'exit_code' => 1, 'output' => $e->getMessage()];
    }
}


// ---------------------------------------------------------------------
// START
// ---------------------------------------------------------------------

echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="robots" content="noindex,nofollow">';
echo '<title>Laravel Deployment</title>';

echo '<style>
body { font-family: Arial, sans-serif; max-width: 1100px; margin: 40px auto; padding: 0 20px; background: #f5f5f5; }
h1 { margin-bottom: 30px; }
section { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; }
pre { background: #111; color: #eee; padding: 15px; overflow-x: auto; border-radius: 5px; }
.ok { color: green; }
.error { color: red; }
</style>';

echo '</head>';
echo '<body>';

echo '<h1>Laravel Deployment</h1>';


// ---------------------------------------------------------------------
// ENVIRONMENT CHECK
// ---------------------------------------------------------------------

echo '<section>';
echo '<h2>Environment</h2>';
echo '<p><strong>PHP:</strong> ' . htmlspecialchars(PHP_VERSION) . '</p>';
echo '<p><strong>Laravel:</strong> ' . htmlspecialchars($app->version()) . '</p>';
echo '<p><strong>Environment:</strong> ' . htmlspecialchars((string) $app->environment()) . '</p>';
echo '</section>';


// ---------------------------------------------------------------------
// 1. MIGRATIONS
// ---------------------------------------------------------------------

echo '<section>';
echo '<h2>1. Database migrations</h2>';

$result = runCommand($kernel, 'migrate', ['--force' => true]);

if (!$result['success']) {
    echo '<h2 class="error">Deployment stopped.</h2>';
    echo '<p class="error"><strong>IMPORTANT:</strong> delete <code>public/deploy.php</code> manually.</p>';
    echo '</section></body></html>';
    exit;
}

echo '</section>';


// ---------------------------------------------------------------------
// 2. STORAGE LINK
// ---------------------------------------------------------------------

echo '<section>';
echo '<h2>2. Storage link</h2>';

$result = runCommand($kernel, 'storage:link');

if (!$result['success']) {
    echo '<p>Storage link could not be created (it may already exist).</p>';
}

echo '</section>';


// ---------------------------------------------------------------------
// 3. CLEAR OLD CACHES
// ---------------------------------------------------------------------

echo '<section>';
echo '<h2>3. Clear application caches</h2>';

runCommand($kernel, 'optimize:clear');

echo '</section>';


// ---------------------------------------------------------------------
// 4. CACHE CONFIGURATION
// ---------------------------------------------------------------------

echo '<section>';
echo '<h2>4. Cache configuration</h2>';

runCommand($kernel, 'config:cache');

echo '</section>';


// ---------------------------------------------------------------------
// 5. CACHE ROUTES
// ---------------------------------------------------------------------

echo '<section>';
echo '<h2>5. Cache routes</h2>';

$result = runCommand($kernel, 'route:cache');

if (!$result['success']) {
    echo '<p>Route caching failed. This happens if routes/web.php contains closures.</p>';
}

echo '</section>';


// ---------------------------------------------------------------------
// 6. CACHE VIEWS
// ---------------------------------------------------------------------

echo '<section>';
echo '<h2>6. Cache views</h2>';

runCommand($kernel, 'view:cache');

echo '</section>';


// ---------------------------------------------------------------------
// FINISHED + SELF DELETE
// ---------------------------------------------------------------------

echo '<section>';
echo '<h2 class="ok">Deployment completed</h2>';

if (@unlink(__FILE__)) {
    echo '<p class="ok"><strong>deploy.php was deleted automatically.</strong></p>';
} else {
    echo '<p class="error"><strong>IMPORTANT:</strong> could not delete the file. ';
    echo 'Delete <code>public/deploy.php</code> immediately.</p>';
}

echo '</section>';

echo '</body>';
echo '</html>';
