<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->role != Role::ADMIN->value){
            throw new AuthenticationException("You are unauthorized");
        }
        return $next($request);
    }
}
