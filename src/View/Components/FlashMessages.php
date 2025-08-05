<?php

declare(strict_types=1);

namespace GranadaPride\LaravelFlash\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class FlashMessages extends Component
{
    public function render(): View
    {
        $framework = config('flash-notifications.framework', 'bootstrap');

        return view("flash-notifications::{$framework}.flash");
    }
}
