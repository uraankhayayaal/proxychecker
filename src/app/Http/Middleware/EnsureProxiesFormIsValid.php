<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProxiesFormIsValid
{
    const IP_PATTERN = '/^\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?):\d{1,5}\b$/';
    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $singleSpace = preg_replace('!\s+!', ' ', $request->input('proxies'));
        $addresses = explode(" ", $singleSpace);

        $error = false;

        foreach ($addresses as $address)
        {
            if (!preg_match(self::IP_PATTERN, $address))
            {
                $error = true;
            }
        }

        if ($error)
        {
            return redirect('/');
        }

        return $next($request);
    }
}
