<?php

namespace Alphavel\Framework\Console\Commands;

use Alphavel\Framework\Console\Command;

/**
 * Route Clear Command
 *
 * Remove o cache de rotas
 */
class RouteClearCommand extends Command
{
    protected string $signature = 'route:clear';

    protected string $description = 'Remove the route cache file';

    public function handle(): int
    {
        $cachePath = getcwd() . '/storage/cache/routes.php';

        if (! file_exists($cachePath)) {
            $this->comment('Route cache does not exist.');

            return 0;
        }

        unlink($cachePath);
        $this->info('✓ Route cache cleared!');

        return 0;
    }
}
