<?php

declare(strict_types=1);

namespace GranadaPride\LaravelFlash\Facades;

use Illuminate\Support\Facades\Facade;

class Flash extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'flash';
    }
}
