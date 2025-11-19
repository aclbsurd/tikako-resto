<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            
            if (Auth::user()->role === 'admin') {
                return $next($request); 
            }
            
            return redirect('/')->with('error', 'Akses Ditolak. Anda tidak memiliki izin Admin.');
        }
        
        return redirect('/admin/login');
    }
}