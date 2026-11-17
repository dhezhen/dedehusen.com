<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class TrackPageVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if ($request->isMethod('get') && $response->isSuccessful() && ! $request->expectsJson()) {
            $today = Carbon::today();
            $hash = hash_hmac('sha256', ($request->ip() ?? 'unknown').'|'.$today->toDateString(), config('app.key'));
            $host = parse_url((string) $request->headers->get('referer'), PHP_URL_HOST);

            Visit::query()->insertOrIgnore([
                'path' => '/'.ltrim($request->path(), '/'),
                'visitor_hash' => $hash,
                'referrer_host' => $host,
                'created_at' => $today,
                'updated_at' => now(),
            ]);
        }
    }
}
