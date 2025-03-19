<?php

namespace Chrishenrique\LaravelAssets\Commands;

use Illuminate\Console\Command;
use Chrishenrique\LaravelAssets\Facades\AssetManager;

class ListAssetsCommand extends Command
{
    protected $signature = 'assets:list';
    protected $description = 'Lista todos os assets registrados';

    public function handle()
    {
        $assets = AssetManager::all();
        foreach ($assets as $type => $items) {
        $this->info(ucfirst($type) . ":");
        
        if (empty($items)) {
            $this->info("  Nenhum asset do tipo {$type} encontrado.");
            continue;
        }

        foreach ($items as $name => $asset) {
            $this->line("  - {$name} ({$asset['position']})");
            $this->line("    URL: {$asset['url']}");
            $this->line("    Ordem: {$asset['order']}");
            $this->line("    ---------------------------------");
        }
    }
    }
}