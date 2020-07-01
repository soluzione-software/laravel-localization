<?php

namespace SoluzioneSoftware\Localization\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use SoluzioneSoftware\Localization\Facades\Localization;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Localize
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure  $next
     *
     * @throws HttpException
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        App::setLocale(Localization::current());

        return $next($request);
    }
}
