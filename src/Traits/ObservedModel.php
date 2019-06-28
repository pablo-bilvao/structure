<?php

namespace Structure\Basic\Traits;

use Structure\Basic\Observers\SynchronizeObserver;

trait Observed
{
    public static function boot() {
        parent::boot();

        parent::observe(SynchronizeObserver::class);        
    }
}

