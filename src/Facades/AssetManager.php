<?php

namespace Chrishenrique\LaravelAssets\Facades;

use Illuminate\Support\Facades\Facade;

class AssetManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'asset.manager'; // Nome do binding no container
    }
}