<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ChangeMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($mode = $request->session()->get('mode')) {
            $mode = $mode?:'live';
            DB::purge(['demo' => 'live', 'live' => 'demo'][$mode]);
            DB::setDefaultConnection($mode);
            $request->user()->setConnection($mode);
        }

        return $next($request);
    }
}
