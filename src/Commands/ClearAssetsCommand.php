<?php

namespace Chrishenrique\LaravelAssets\Commands;

use Illuminate\Console\Command;
use function LaravelAssets\assetManager;

class ClearAssetsCommand extends Command
{
    protected $signature = 'assets:clear';
    protected $description = 'Limpa todos os assets registrados';

    public function handle()
    {
        assetManager()->clear();
        $this->info('Todos os assets foram removidos.');
    }
}