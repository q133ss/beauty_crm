<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth()->check()){
            return to_route('login');
        }

        $role = Auth()->user()->role->name;

        $accept_roles = [
            'admin',
            'master'
        ];
        //Если роли нет в массиве, то запрещаем доступ
        abort_if(!in_array($role, $accept_roles), 403, 'Доступ запрещен');

        return $next($request);
    }
}
