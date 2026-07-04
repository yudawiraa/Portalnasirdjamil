<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProtectPrivateSite
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('site.private.enabled')) {
            return $next($request);
        }

        if (! $this->hasValidCredentials($request)) {
            return response('Situs sedang dalam mode review terbatas.', 401)
                ->header('WWW-Authenticate', $this->authenticateHeader())
                ->header('X-Robots-Tag', 'noindex, nofollow, noarchive');
        }

        $response = $next($request);
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');

        return $response;
    }

    private function hasValidCredentials(Request $request): bool
    {
        $user = (string) config('site.private.user', 'review');
        $password = (string) config('site.private.password', '');

        if ($password === '') {
            return false;
        }

        return hash_equals($user, (string) $request->getUser())
            && hash_equals($password, (string) $request->getPassword());
    }

    private function authenticateHeader(): string
    {
        $realm = str_replace('"', '', (string) config('site.private.realm', 'Portal Nasir Djamil Review'));

        return 'Basic realm="'.$realm.'"';
    }
}
