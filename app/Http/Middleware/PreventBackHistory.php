<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class PreventBackHistory
{
    public function handle($request, Closure $next)
    {
        Log::info('PreventBackHistory middleware executed');

        $response = $next($request);

        return $response->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}

